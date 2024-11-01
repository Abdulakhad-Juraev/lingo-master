<?php

namespace common\models;

use common\modules\testmanager\models\Test;
use common\modules\usermanager\models\Student;
use soft\db\ActiveQuery;
use soft\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "university_statistics".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $count
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 */
class UniversityStatistics extends ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">


    public static function tableName(): string
    {
        return 'university_statistics';
    }


    public function rules()
    {
        return [
            [['status', 'count', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }


    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
        ];
    }


    public function labels()
    {
        return [
            'id' => 'ID',
            'count' => 'Count',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">


    //</editor-fold>

    /**
     * @return bool|int|string|null
     */
    public static function studentsCount()
    {
        return Student::find()
            ->active()
            ->count();
    }

    public static function testsCount()
    {
        return Test::find()
            ->active()
            ->count();
    }
}
