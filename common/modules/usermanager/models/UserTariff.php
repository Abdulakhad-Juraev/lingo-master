<?php

namespace common\modules\usermanager\models;

use common\models\User;
use common\modules\tariff\models\Tariff;
use common\modules\testmanager\models\UserPayment;
use common\modules\usermanager\models\query\UserTariffQuery;
use common\traits\PaymentTypeTrait;
use Yii;

/**
 * This is the model class for table "user_tariff".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $tariff_id
 * @property int|null $price
 * @property int|null $started_at
 * @property int|null $expired_at
 * @property int|null $order_id
 * @property int|null $type_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property Order $order
 * @property Tariff $tariff
 * @property User $updatedBy
 * @property User $user
 */
class UserTariff extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">
    use PaymentTypeTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tariff_id'], 'required'],
            [['user_id', 'tariff_id', 'payment_type_id', 'price', 'started_at', 'expired_at', 'order_id', 'type_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['tariff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tariff::className(), 'targetAttribute' => ['tariff_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public static function find()
    {
        return new UserTariffQuery(get_called_class());
    }

    public function userPayment()
    {


        $transaction = Yii::$app->db->beginTransaction();
        $success = true;
        try {
            $success &= user()->purchaseTariffAdmin($this->tariff,$this->user_id,PaymentTypeTrait::$type_cash);
            $user_payment = new UserPayment([
                'user_id' => $this->user_id,
                'amount' => $this->tariff->price,
                'type_id' => UserPayment::PAYMENT_TYPE_ID_CASH,
                'table_id' => $this->id,
                'owner_id' => UserPayment::OWNER_ID_TARIFF
            ]);
            $success &= $user_payment->save();

            if ($success) {
                $transaction->commit();
                return true;
            }
            return false;
        } catch (\Exception $exception) {
            return false;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tariff_id' => 'Tariff ID',
            'price' => 'Price',
            'started_at' => 'Started At',
            'expired_at' => 'Expired At',
            'order_id' => 'Order ID',
            'type_id' => 'Type ID',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariff()
    {
        return $this->hasOne(Tariff::className(), ['id' => 'tariff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    //</editor-fold>
}
