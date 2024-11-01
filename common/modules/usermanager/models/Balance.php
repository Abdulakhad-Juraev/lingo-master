<?php

namespace common\modules\usermanager\models;

use common\modules\testmanager\models\Test;
use Yii;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "balance".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $type
 * @property int|null $value
 * @property int|null $total
 * @property int|null $reason
 * @property string|null $comment
 * @property int|null $test_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property Test $test
 * @property User $updatedBy
 * @property User $user
 */
class Balance extends \soft\db\ActiveRecord
{
    public const TYPE_INCOME = 1;
    public const TYPE_EXPENSE = 2;

    public const REASON_INITIAL = 1;
    public const REASON_FILL_BALANCE_BY_ADMIN = 2;
    public const REASON_REDUCE_BALANCE_BY_ADMIN = 3;
    public const REASON_EXPENSE_FOR_TEST = 4;
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'value', 'total', 'reason', 'test_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['test_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public static function getTypeList(): array
    {
        return [
            self::TYPE_INCOME => Yii::t('app', 'TYPE_INCOME'),
            self::TYPE_EXPENSE => Yii::t('app', 'TYPE_EXPENSE'),
        ];
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return self::getTypeList()[$this->type] ?? '-';
    }

    /**
     * @return string[]
     */
    public static function getReasonList(): array
    {
        return [
            self::REASON_INITIAL => Yii::t('app', 'REASON_INITIAL'),
            self::REASON_FILL_BALANCE_BY_ADMIN => Yii::t('app', 'REASON_FILL_BALANCE_BY_ADMIN'),
            self::REASON_REDUCE_BALANCE_BY_ADMIN => Yii::t('app', 'REASON_REDUCE_BALANCE_BY_ADMIN'),
            self::REASON_EXPENSE_FOR_TEST => Yii::t('app', 'REASON_EXPENSE_FOR_TEST'),
        ];
    }

    /**
     * @return string
     */
    public function getReasonName(): string
    {
        return self::getReasonList()[$this->reason];
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
            'user_id' => Yii::t('app', 'Client'),
            'type' => Yii::t('app', 'Type'),
            'value' => Yii::t('app', 'Value'),
            'total' => Yii::t('app', 'Total'),
            'reason' => Yii::t('app', 'Reason'),
            'comment' => Yii::t('app','Comments'),
            'test_id' => Yii::t('app','Test'),
            'created_at' => Yii::t('app','Created At'),
            'updated_at' => Yii::t('app','Updated At'),
//            'created_by' => 'Created By',
//            'updated_by' => 'Updated By',
        ];
    }


    /**
     * @throws ServerErrorHttpException
     */
    public static function spendMoneyFromTest(\common\models\User $user, int $test_id, int $money): bool
    {
        $driverTotalBalance = $user->getTotalBalance();
        $newBalance = new self([
            'user_id' => $user->id,
            'type' => self::TYPE_EXPENSE,
            'value' => abs($money),
            'total' => $driverTotalBalance - abs($money),
            'reason' => self::REASON_EXPENSE_FOR_TEST,
            'comment' => Yii::t('app', 'REASON_EXPENSE_FOR_TEST'),
            'test_id' => $test_id,
        ]);
        if ($newBalance->save()) {
            return true;
        }
        return false;
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
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
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
