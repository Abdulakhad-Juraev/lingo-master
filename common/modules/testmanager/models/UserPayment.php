<?php

namespace common\modules\testmanager\models;

use common\modules\usermanager\models\User;
use Yii;

/**
 * This is the model class for table "user_payment".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $amount
 * @property string|null $comment
 * @property string|null $type_id
 * @property int|null $transaction_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $table_id
 * @property int|null $owner_id
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property User $user
 */
class UserPayment extends \soft\db\ActiveRecord
{
    public const PAYMENT_TYPE_ID_CASH = 1;
    public const PAYMENT_TYPE_ID_CARD = 2;

    public const OWNER_ID_TARIFF = 1;
    public const OWNER_ID_TESTENROLL = 2;
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'type_id'], 'required'],
            [['user_id', 'amount', 'transaction_id', 'type_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'table_id', 'owner_id'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'amount' => 'Amount',
            'comment' => 'Comment',
            'type_id' => 'Type ID',
            'transaction_id' => 'Transaction ID',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    //</editor-fold>
}
