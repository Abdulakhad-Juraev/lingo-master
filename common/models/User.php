<?php

namespace common\models;

use common\models\query\UserQuery;

use common\modules\ieltsExam\models\IeltsResult;
use common\modules\regionmanager\models\District;
use common\modules\regionmanager\models\Region;
use common\modules\testmanager\models\TestResult;
use common\modules\university\models\Course;
use common\modules\university\models\Department;
use common\modules\university\models\Direction;
use common\modules\university\models\Faculty;
use common\modules\university\models\Group;
use common\modules\university\models\Language;
use common\modules\usermanager\models\Balance;
use common\modules\usermanager\models\UserTariff;
use common\traits\IeltsResultTrait;
use common\traits\ToeflResultTrait;
use common\traits\UserDeviceTrait;
use common\traits\UserEnrollTrait;
use common\traits\UserTariffTrait;
use soft\helpers\ArrayHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\ServerErrorHttpException;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $img
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read string $authKey
 * @property bool $type_id [tinyint(3)]
 * @property string $firstname [varchar(255)]
 * @property string $lastname [varchar(255)]
 * @property string $full_name [varchar(255)]
 * @property string $passport_series [varchar(255)]
 * @property integer $passport_typ
 * @property string $middle_name[varchar(255)]
 * @property string $photo[varchar(255)]
 * @property string $simple_password[varchar(255)]
 *
 * @property-read mixed $statusName
 * @property-read string $statusBadge
 * @property-read string $fullname
 * @property integer $notice_status
 * @property integer $region_id
 * @property integer $district_id
 * @property integer $passport_number
 * @property integer $faculty_id
 * @property integer $sex
 * @property integer $course_id
 * @property integer $language_id
 * @property integer $department_id
 * @property integer $group_id
 * @property integer $born_date
 * @property integer $direction_id
 * @property boolean $is_accepted_student
 * @property integer $jshshir
 *
 *
 * @property string $Host [char(60)]
 * @property string $User [char(32)]
 * @property string $Select_priv [enum('N', 'Y')]
 * @property string $Insert_priv [enum('N', 'Y')]
 * @property string $Update_priv [enum('N', 'Y')]
 * @property string $Delete_priv [enum('N', 'Y')]
 * @property string $Create_priv [enum('N', 'Y')]
 * @property string $Drop_priv [enum('N', 'Y')]
 * @property string $Reload_priv [enum('N', 'Y')]
 * @property string $Shutdown_priv [enum('N', 'Y')]
 * @property string $Process_priv [enum('N', 'Y')]
 * @property string $File_priv [enum('N', 'Y')]
 * @property string $Grant_priv [enum('N', 'Y')]
 * @property string $References_priv [enum('N', 'Y')]
 * @property string $Index_priv [enum('N', 'Y')]
 * @property string $Alter_priv [enum('N', 'Y')]
 * @property string $Show_db_priv [enum('N', 'Y')]
 * @property string $Super_priv [enum('N', 'Y')]
 * @property string $Create_tmp_table_priv [enum('N', 'Y')]
 * @property string $Lock_tables_priv [enum('N', 'Y')]
 * @property string $Execute_priv [enum('N', 'Y')]
 * @property string $Repl_slave_priv [enum('N', 'Y')]
 * @property string $Repl_client_priv [enum('N', 'Y')]
 * @property string $Create_view_priv [enum('N', 'Y')]
 * @property string $Show_view_priv [enum('N', 'Y')]
 * @property string $Create_routine_priv [enum('N', 'Y')]
 * @property string $Alter_routine_priv [enum('N', 'Y')]
 * @property string $Create_user_priv [enum('N', 'Y')]
 * @property string $Event_priv [enum('N', 'Y')]
 * @property string $Trigger_priv [enum('N', 'Y')]
 * @property string $Create_tablespace_priv [enum('N', 'Y')]
 * @property string $ssl_type [enum('', 'ANY', 'X509', 'SPECIFIED')]
 * @property string $ssl_cipher [blob]
 * @property string $x509_issuer [blob]
 * @property string $x509_subject [blob]
 * @property int $max_questions [int(11) unsigned]
 * @property int $max_updates [int(11) unsigned]
 * @property int $max_connections [int(11) unsigned]
 * @property int $max_user_connections [int(11) unsigned]
 * @property string $plugin [char(64)]
 * @property string $authentication_string
 * @property string $password_expired [enum('N', 'Y')]
 * @property int $password_last_changed [timestamp]
 * @property int $password_lifetime [smallint(5) unsigned]
 * @property int $read_notice_time [smallint(5) unsigned]
 * @property string $account_locked [enum('N', 'Y')]
 * @property-read null|string $firstErrorMessage
 *
 * @property-read Region $region
 * @property-read District $district
 * @property-read District $faculty
 * @property-read District $department
 * @property-read District $direction
 * @property-read District $group
 * @property-read UserTariff $lastUserTariff
 * @property-read IeltsResult $activeIeltsTest
 */
class User extends ActiveRecord implements IdentityInterface
{
    use UserDeviceTrait;
    use UserTariffTrait;
    use ToeflResultTrait;
    use IeltsResultTrait;
    public const TYPE_ID_TEACHER = 1;
    public const TYPE_ID_STUDENT = 2;
    public const TYPE_ID_USER = 3;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;

    const NOTICE_STATUS_ACTIVE = 1;
    const NOTICE_STATUS_INACTIVE = 0;


    public const SEX_TYPE_MALE = 1;
    public const SEX_TYPE_WOMAN = 2;


    public const EDUCATIONAL_TYPE_BACHELOR = 1;

    public const EDUCATIONAL_TYPE_MASTER = 2;

    public const EDUCATIONAL_FROM_DAY_TIME = 1;

    public const EDUCATIONAL_TYPE_EVNING = 2;
    public const EDUCATIONAL_TYPE_OUTSIDE = 3;
    /**
     * @var mixed|null
     */

    public static function sexTypes(): array
    {
        return [
            self::SEX_TYPE_MALE => 'Erkak',
            self::SEX_TYPE_WOMAN => 'Ayol',
        ];
    }

    public static function sexTypesUz(): array
    {
        return [
            self::SEX_TYPE_MALE => 'Erkak',
            self::SEX_TYPE_WOMAN => 'Ayol',
        ];
    }

    public function sexTypeName()
    {
        return ArrayHelper::getArrayValue(self::sexTypes(), $this->sex, $this->sex);
    }

    public function sexTypeNameUz()
    {
        return ArrayHelper::getArrayValue(self::sexTypes(), $this->sex, $this->sex);
    }


    public static function educationalTypes(): array
    {
        return [
            self::EDUCATIONAL_TYPE_BACHELOR => t('EDUCATIONAL_TYPE_BACHELOR'),
            self::EDUCATIONAL_TYPE_MASTER => t('EDUCATIONAL_TYPE_MASTER'),
        ];
    }

    public static function educationalTypesUz(): array
    {
        return [
            self::EDUCATIONAL_TYPE_BACHELOR => 'Bakalavr',
            self::EDUCATIONAL_TYPE_MASTER => 'Magistr',
        ];
    }


    public function educationalTypeName()
    {
        return ArrayHelper::getArrayValue(self::educationalTypes(), $this->educational_type, $this->educational_type);
    }

    public static function educationalForm(): array
    {
        return [
            self::EDUCATIONAL_FROM_DAY_TIME => t('EDUCATIONAL_FROM_DAY_TIME'),
            self::EDUCATIONAL_TYPE_EVNING => t('EDUCATIONAL_TYPE_EVENING'),
            self::EDUCATIONAL_TYPE_OUTSIDE => t('EDUCATIONAL_TYPE_OUTSIDE'),
        ];
    }

    public static function educationalFormUz(): array
    {
        return [
            self::EDUCATIONAL_FROM_DAY_TIME => 'Kunduzgi',
            self::EDUCATIONAL_TYPE_EVNING => 'Kechki',
            self::EDUCATIONAL_TYPE_OUTSIDE => 'Sirtqi',
        ];
    }

    public function educationalFormName()
    {
        return ArrayHelper::getArrayValue(self::educationalForm(), $this->educational_form, $this->educational_form);
    }


    /**
     * Yangi user qo'shishda kerak bo'ladi
     */
    const SCENARIO_REGISTER = 'register';


    const SCENARIO_CREATE_BY_ADMIN = 'create_by_admin';

    /**
     * Admin tomonidan filiallardagi xodim (menejer va konsultantlar)ni
     * tahrirlashda kerak bo'ladi
     */
    const SCENARIO_UPDATE_BY_ADMIN = 'update_by_admin';
    const SCENARIO_UPDATE = 'update';

    public $password;


    //<editor-fold desc="Parent methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function types(): array
    {
        return [
            self::TYPE_ID_TEACHER => t('Teacher'),
            self::TYPE_ID_STUDENT => t('Student'),
            self::TYPE_ID_USER => t('User'),
        ];
    }

    public function typeName()
    {
        return ArrayHelper::getArrayValue(self::types(), $this->type_id, $this->type_id);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        $this->status = self::STATUS_DELETED;
        $this->save(false);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'message' => t('Exists Username')],
            [['username', 'full_name'], 'required'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['username', 'full_name', 'passport_series', 'born_date', 'auth_key', 'simple_password'], 'string', 'max' => 255],
            [['region_id', 'district_id', 'sex', 'passport_number', 'passport_type', 'faculty_id', 'department_id', 'group_id', 'direction_id', 'language_id', 'course_id', 'type_id', 'jshshir'], 'integer'],
            ['password', 'string', 'min' => 5],
            ['password', 'trim'],
            ['is_accepted_student', 'boolean'],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['sex', 'in', 'range' => [self::SEX_TYPE_MALE, self::SEX_TYPE_WOMAN]],
            ['password', 'required', 'on' => [self::SCENARIO_CREATE_BY_ADMIN],]
        ];
    }


    public function fields()
    {
        return [
            'id',
            'username',
            'full_name',
            'password_hash',
            'status',
            'img' => function ($model) {
                return $model->getImage();
            },
            'notice_status',
            'auth_key',
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => t('Login'),
            'full_name' => t('Full Name'),
            'updated_at' => t('Updated At'),
//            'middle_name' => 'Otasining ismi',
            'photo' => t('Image'),
            'password' => t('Password'),
            'department_id' => t('Department'),
            'faculty_id' => t('Faculty'),
            'region_id' => t('Region'),
            'district_id' => t('District'),
            'born_date' => t('Born Date'),
            'passport_series' => t('Passport Series'),
            'passport_number' => t('Passport number'),
            'passport_type' => t('Passport Type'),
            'jshshir' => t('JShShIR'),
            'direction_id' => t('Direction'),
            'group_id' => t('Group'),
            'language_id' => t('Language'),
            'course_id' => t('Course'),
            'auth_key' => t('Token'),
            'educational_type' => t('Educational Type'),
            'educational_form' => t('Educational Form'),
            'firstname' => t('Username'),
            'lastname' => t('Lastname'),
            'status' => t('Status'),
            'sex' => t('Gender'),
            'created_at' => t('Created At'),
            'balance' => t('Balance'),


        ];
    }

    public function beforeSave($insert)
    {
        // Define characters to remove
        $charactersToRemove = [')' => '', '(' => '', '-' => '', '+' => '', ' ' => ''];

        // Remove specified characters from the username
        $this->username = str_replace(array_keys($charactersToRemove), $charactersToRemove, $this->username);

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['firstname', 'lastname', 'username', 'password', 'img', 'region_id', 'district_id', 'sex', 'born_date'];
        $scenarios[self::SCENARIO_CREATE_BY_ADMIN] = ['educational_type', 'educational_form', 'esx', 'full_name', 'username', 'password', 'status', 'faculty_id', 'middle_name', 'region_id', 'district_id', 'department_id', 'group_id', 'direction_id', 'type_id'];
        $scenarios[self::SCENARIO_UPDATE_BY_ADMIN] = ['full_name', 'username', 'password', 'status'];
        $scenarios[self::SCENARIO_UPDATE] = ['full_name', 'photo', 'region_id', 'district_id', 'sex', 'born_date'];
        return $scenarios;
    }

    /**
     * @return \common\models\query\UserQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    //</editor-fold>

    //<editor-fold desc="Required methods" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }


    /**
     * {@inheritdoc}
     */

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->andWhere(['username' => $username, 'status' => self::STATUS_ACTIVE])->with(['region', 'district'])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        $exploded = explode(':', $token);
        if (!is_numeric($exploded[0])) {
            return null;
        }
        $user = static::findOne([
            'id' => $exploded[0]
        ]);

        if ($user && $user->auth_key === $token) {
            return $user;
        }

        return null;
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    //</editor-fold>

    //<editor-fold desc="Additional" defaultstate="collapsed">

    /**
     * @param string $permissionName
     * @param array $params
     * @return bool
     */
    public function can($permissionName, $params = [])
    {
        return Yii::$app->authManager->checkAccess($this->getId(), $permissionName, $params);
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->full_name;
    }

    /**
     * @return string the first error text of the model after validating
     * */
    public function getFirstErrorMessage()
    {
        $firstErrors = $this->firstErrors;
        if (empty($firstErrors)) {
            return null;
        }
        $array = array_values($firstErrors);
        return ArrayHelper::getArrayValue($array, 0, null);
    }


    //</editor-fold>

    //<editor-fold desc="Status" defaultstate="collapsed">

    /**
     * @return string[]
     */
    public static function statuses()
    {
        return [
            self::STATUS_ACTIVE => t('Active'),
            self::STATUS_INACTIVE => t('Inactive'),
        ];
    }

    /**
     * @return mixed|null
     */
    public function getStatusName()
    {
        return ArrayHelper::getArrayValue(self::statuses(), $this->status, $this->status);
    }

    /**
     * @return string
     */
    public function getStatusBadge(): string
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                return '<span class="badge badge-success">' . t('Active') . '</span>';
            case self::STATUS_INACTIVE:
                return '<span class="badge badge-danger">' . t('Inactive') . '</span>';
            case self::STATUS_DELETED:
                return '<span class="badge badge-default">' . t('Off') . '</span>';
            default:
                return '<span class="badge badge-default">' . $this->status . '</span>';
        }
    }

    //</editor-fold>

    //<editor-fold desc="Image" defaultstate="collapsed">
    /**
     * @return string
     */
    public function getImage()
    {
        return $this->img ? Yii::$app->request->hostInfo . '/uploads/user/' . $this->img : '';
    }

    //</editor-fold>

    //<editor-fold desc="RBAC" defaultstate="collapsed">

    /**
     * @throws \Exception
     */
    public function assignRole(string $roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role == null) {
            $role = $auth->createRole($roleName);
            $auth->add($role);
        }
        $auth->assign($role, $this->id);
    }

    /**
     * Revokes a role from a user.
     * @param $roleName string Role name
     * @throws \Exception
     */
    public function revokeRole($roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role != null) {
            $assign = $auth->getAssignment($roleName, $this->id);
            if ($assign != null) {
                $auth->revoke($role, $this->id);
            }
        }
    }

    //</editor-fold>

    /**
     * @return array
     */
    public static function users()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }

    public function getPhotoUrl(): string
    {
        if ($this->photo) {
            return '/uploads/user/' . $this->photo;
        }
        return '/template/images/avatar-1.png';
    }

    public function afterSave($insert, $changedAttributes)
    {
        $token = explode(':', $this->auth_key);
        if (!is_numeric($token[0])) {
            $this->auth_key = $this->id . ":" . $this->auth_key;
            $this->save(false);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }

    public function getGroup(): ActiveQuery
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    public function getDirection(): ActiveQuery
    {
        return $this->hasOne(Direction::className(), ['id' => 'direction_id']);
    }

    public function getCourse(): ActiveQuery
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    public function getLanguage(): ActiveQuery
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDepartment(): ActiveQuery
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDistrict(): ActiveQuery
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRegion(): ActiveQuery
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getActiveUserTest(): ActiveQuery
    {
        return $this->hasOne(TestResult::className(), ['user_id' => 'id'])
            ->andWhere(['status' => TestResult::STATUS_ACTIVE]);
    }

    public function getTotalBalance(): int
    {
        $balance = Balance::find()
            ->where(['user_id' => $this->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (!$balance) {
            $balance = new Balance([
                'user_id' => $this->id,
                'type' => Balance::TYPE_INCOME,
                'value' => 0,
                'total' => 0,
                'reason' => Balance::REASON_INITIAL
            ]);

            if (!$balance->save()) {
                throw new ServerErrorHttpException(t('Error creating user balance') . ': ' . $balance->firstErrors[0] ?? '-');
            }
        }

        return $balance->total;
    }

    /**
     * @throws ServerErrorHttpException
     */
    public function addBalance(int $money, int $reason, int $test_id = null): int
    {
        $totalBalance = $this->getTotalBalance();
        if ($money > 0) {
            $newBalance = new Balance([
                'user_id' => $this->id,
                'type' => Balance::TYPE_INCOME,
                'value' => abs($money),
                'total' => $totalBalance + abs($money),
                'reason' => $reason,
                'test_id' => $test_id
            ]);
        } else {
            $newBalance = new Balance([
                'user_id' => $this->id,
                'type' => Balance::TYPE_EXPENSE,
                'value' => abs($money),
                'total' => $totalBalance - abs($money),
                'reason' => $reason,
                'test_id' => $test_id
            ]);
        }
        if (!$newBalance->save()) {
            throw new ServerErrorHttpException(t('Error creating user balance') . $newBalance->firstErrors[0] ?? '-');
//            throw new ServerErrorHttpException("{$this->getFullname()} nomli foydalanuvchi {$money} so'm balans qo'shishda xatolik yuz berdi: " . $newBalance->firstErrors[0] ?? '-');
        }
        return $newBalance->id;
    }

    public function getImageUrl()
    {
        return $this->photo ? Yii::$app->urlManager->hostInfo . '/uploads/user/' . $this->photo : Yii::$app->urlManager->hostInfo . '/template/images/avatar-1.png';
    }

    public static function map()
    {
        return ArrayHelper::map(
            self::find()
                ->where(['status' => self::STATUS_ACTIVE])
                ->andWhere(['not', ['type_id' => null]])
                ->all(),
            'id',
            function (self $model) {
                return $model->full_name;
            }
        );
    }
    public function getLastUserTariff()
    {
        return $this->hasOne(UserTariff::class, ['user_id' => 'id'])
            ->orderBy(['expired_at' => SORT_DESC]);
    }
}
