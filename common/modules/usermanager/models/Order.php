<?php

namespace common\modules\usermanager\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $price
 * @property int|null $type_id
 * @property int|null $tariff_id
 * @property int|null $test_id
 * @property int|null $exam_id
 * @property int|null $payment_type_id To'lov turi
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property UserTariff[] $userTariffs
 */
class Order extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'order';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['user_id', 'price', 'type_id', 'tariff_id', 'test_id', 'exam_id', 'payment_type_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
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
            'price' => 'Price',
            'type_id' => 'Type ID',
            'tariff_id' => 'Tariff ID',
            'test_id' => 'Test ID',
            'exam_id' => 'Exam ID',
            'payment_type_id' => 'Payment Type ID',
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserTariffs()
    {
        return $this->hasMany(UserTariff::className(), ['order_id' => 'id']);
    }
    
    //</editor-fold>
}
