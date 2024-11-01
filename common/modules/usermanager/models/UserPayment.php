<?php

namespace common\modules\usermanager\models;

use soft\helpers\ArrayHelper;
use Yii;
use yii\db\ActiveQuery;

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

    //<editor-fold desc="Parent" defaultstate="collapsed">

    public static function tableName(): string
    {
        return 'user_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'transaction_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'required'],
            [['comment'], 'string', 'max' => 255],
            [['type_id'], 'string', 'max' => 10],
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
    public function labels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => t('User'),
            'amount' => t('Amount'),
            'comment' => t('Comment'),
            'type_id' => t('Payment type'),
            'transaction_id' => t('Transaction ID'),
        ];
    }


    public static function paymentTypes(): array
    {
        return [
            self::PAYMENT_TYPE_ID_CASH => t('Cash'),
            self::PAYMENT_TYPE_ID_CARD => t('By card')
        ];
    }

    public function paymentTypeName()
    {
        return ArrayHelper::getArrayValue(self::paymentTypes(), $this->type_id, $this->type_id);
    }


    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    //</editor-fold>
}
