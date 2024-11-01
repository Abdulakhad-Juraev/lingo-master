<?php

namespace frontend\models;

use common\modules\auth\models\TempUser;
use common\models\User;
use soft\helpers\PhoneHelper;
use Yii;
use yii\base\Model;

class ResetForm extends Model
{
    public $username;
    public $firstname;
    public $lastname;
    public $password;
    public $password_repeat;
    public $code;
    public $email;

    const SESSION_TEMP_USER_ID_KEY = '_temp_user_id';
    const SCENARIO_PHONE = 'phone';
    const SCENARIO_VERIFY = 'verify';
    const SCENARIO_RESET_PASSWORD = 'reset_password';
    const SCENARIO_REGISTER = 'register';

    /**
     * Tasdiqlash kodining amal muddati (sekund)
     */
    const VERIFICATION_DURATION = 120;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username'], 'required'],
            [['firstname', 'lastname'], 'string', 'min' => 2, 'max' => 255],
            [['firstname'], 'required', 'message' => Yii::t('app', 'Firstname is required.')],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Ushbu telefon raqam allaqachon band qilingan'],
            ['username', 'match', 'pattern' => '/\+998\(\d{2}\) \d{3}\-\d{2}\-\d{2}/', 'message' => t("Telefon raqam formati not'g'ri")],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['password_repeat'], 'required', 'message' => Yii::t('app', "Takroriy parol to'ldirilishi shart")],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', "Takroriy parollar mos kelmadi")],

            ['username', 'checkPhone', 'on' => self::SCENARIO_PHONE],

            ['code', 'required', 'message' => Yii::t('app', 'Enter the code')],
            ['code', 'integer'],
            ['code', 'match', 'pattern' => '/|d{4}/', 'message' => Yii::t('app', 'Kiritilgan kod noto\'g\'ri')],
            ['code', 'checkCode', 'on' => self::SCENARIO_VERIFY],
        ];
    }

    /**
     * @return array|array[]
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PHONE] = ['username'];
        $scenarios[self::SCENARIO_VERIFY] = ['code'];
        $scenarios[self::SCENARIO_REGISTER] = ['firstname', 'lastname', 'password', 'password_repeat'];
        $scenarios[self::SCENARIO_RESET_PASSWORD] = ['password', 'password_repeat'];
        return $scenarios;
    }

    /**
     * Remove everything but numbers
     * @param $phoneNumber mixed
     * @return array|string|string[]|null
     */
    public function clearPhoneNumber()
    {
        return $this->username = PhoneHelper::clearPhoneNumber($this->username);
    }

    //<editor-fold desc="Step 1: Enter and check phone number, send code via sms" defaultstate="collapsed">

    /**
     * Kiritilgan tel. raqam bazada bor yoki yo'qligini tekshirish
     * Agar mavjud bo'lsa, false qaytaradi
     */
    public function checkPhone()
    {
        $phone = $this->clearPhoneNumber();

        if (!empty($phone)) {

            $user = User::findOne(['username' => $phone]);
            if ($user == null) {
                $this->addError('username', 'Bunday telefon raqam ro\'yhatga olinmagan!');
            } else {
                return true;
            }
        }
        return false;
    }


    public function generateCode()
    {
        return 7777;
//        return mt_rand(1000, 9999);
    }

    /**
     * Tel. raqam to'g'ri kiritilgandan keyin, ixtiyoriy kodni generatsiya qilish
     *  va kodni sms orqali jo'natish
     * @throws \yii\db\Exception
     */
    public function saveTempUser()
    {
        $code = $this->generateCode();
        $transaction = Yii::$app->db->beginTransaction();

        $tempUser = new TempUser([
            'code' => (string)$code,
            'phone' => $this->clearPhoneNumber(),
            'expire_at' => time() + self::VERIFICATION_DURATION
        ]);

        if ($tempUser->save() && $this->sendCodeViaSms($code)) {
            Yii::$app->session->set(self::SESSION_TEMP_USER_ID_KEY, $tempUser->id);
            $transaction->commit();
            return true;
        } else {
            $transaction->rollBack();
        }

        return false;
    }

    /**
     * Kodni sms orqali jo'natish
     */
    public function sendCodeViaSms($code)
    {

//        $domain = "https://eduskills.siyratmedia.uz/" . ' da.';
//        $message = $domain . Yii::t('app', 'signup_verify_sms_message') . '' . $code;

//        return Yii::$app->sms->send($this->clearPhoneNumber(), $message);
        return true;
    }

    // </editor-fold>

    //<editor-fold desc="Step 2: Verify phone number via code" defaultstate="collapsed">

    /**
     * @return bool
     */
    public function checkCode()
    {

        $id = Yii::$app->session->get(self::SESSION_TEMP_USER_ID_KEY);
        $tempUser = TempUser::find()
            ->andWhere([
                'id' => $id,
                'code' => $this->code,
                'is_verified' => false,
                'is_registered' => false,
            ])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (!$tempUser) {
            $this->addError('code', Yii::t('app', 'Invalid verification code'));
            return false;
        }

        if ($tempUser->isExpired) {
            $this->addError('code', Yii::t('app', 'Verification code has been expired'));
            return false;
        }

        $tempUser->is_verified = true;

        return $tempUser->save(false);
    }

    // </editor-fold>

    //<editor-fold desc="Step 3: Sign Up User">
    /**
     * @throws \yii\base\Exception
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $id = Yii::$app->session->get(self::SESSION_TEMP_USER_ID_KEY);
        $tempUser = TempUser::find()
            ->andWhere([
                'id' => $id,
                'is_verified' => true,
                'is_registered' => false,
            ])
            ->one();
        if (!$tempUser) {
            $this->addError('firstname', Yii::t('app', 'An error occurred'));
            return false;
        }

        $user = User::findOne(['username' => $tempUser->phone]);

        $user->username = $tempUser->phone;
        $user->setPassword($this->password);
//        $user->firstname = $user->firstname;
//        $user->lastname = $user->lastname;
        $user->status = User::STATUS_ACTIVE;
        $user->generateAuthKey();

        if ($user->save()) {
            Yii::$app->user->login($user);
            $tempUser->is_registered = true;
            $tempUser->save(false);
            return true;
        } else {
            $this->addError('firstname', $user->getErrors());
        }
        return false;

    }

    //</editor-fold>

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Phone'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'password' => 'Yangi parol',
            'password_repeat' => "Yangi parolni takrorlang",
            'code' => "Kodni kiriting"
        ];
    }

}