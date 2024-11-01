<?php

namespace common\modules\toeflExam\models;

use api\modules\toefl\models\ListeningGroup;
use common\models\User;
use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\IeltsQuestions;
use odilov\multilingual\behaviors\MultilingualBehavior;
use soft\behaviors\UploadBehavior;
use soft\db\ActiveQuery;
use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "english_exam".
 *
 * @property int $id
 * @property string|null $short_description
 * @property string|null $title
 * @property int|null $price
 * @property int|null $number_attempts
 * @property string|null $img
 * @property int|null $type
 * @property int|null $reading_duration
 * @property int|null $listening_duration
 * @property int|null $writing_duration
 * @property int|null $speaking_duration
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property ToeflQuestion[] $toeflQuestions
 */
class EnglishExam extends \soft\db\ActiveRecord
{

    public const TYPE_TOEFL = 1;
    public const TYPE_IELTS = 2;
    public const TYPE_CEFR = 3;

    public static function types(): array
    {
        return [
            self::TYPE_TOEFL => 'TOEFL',
            self::TYPE_IELTS => 'IELTS',
            self::TYPE_CEFR => 'CEFR',
        ];
    }

    public function typeName()
    {
        return ArrayHelper::getArrayValue(self::types(), $this->type, $this->type);
    }

    //<editor-fold desc="Parent" defaultstate="collapsed">

    public static function tableName(): string
    {
        return 'english_exam';
    }

    public function rules()
    {
        return [
            [['short_description_uz', 'title_uz', 'price', 'type'], 'required'],
            [['short_description'], 'string'],
            ['number_attempts', 'default', 'value' => 1],
            [['price', 'number_attempts', 'type', 'reading_duration', 'listening_duration', 'speaking_duration', 'writing_duration', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['img'], 'file', 'extensions' => 'png, jpeg', 'maxSize' => 1024 * 1024 * 2], // maxSize ni baytlarda ko'rsatilgan
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            'multilingual' => [
                'class' => MultilingualBehavior::class,
                'attributes' => ['title', 'short_description'],
                'languages' => $this->languages(),
            ],

            [
                'class' => UploadBehavior::class,
                'attribute' => 'img',
                'scenarios' => ['default'],
                'path' => '@frontend/web/uploads/english-exam/{id}',
                'url' => '/uploads/english-exam/{id}',
            ],
        ];
    }

    public static function find(): ActiveQuery
    {
        return parent::find()->multilingual();
    }


    public function labels()
    {
        return [
            'id' => 'ID',
            'short_description' => t('Short Description'),
            'title' => t('Title'),
            'price' => t('Cost'),
            'number_attempts' => t('Number Attempts'),
            'img' => t('Image'),
            'type' => t('Type'),
            'reading_duration' => t('Reading Duration'),
            'listening_duration' => t('Listening Duration'),
            'writing_duration' => t('Writing Duration'),
            'speaking_duration' => t('Speaking Duration'),
        ];
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

    public function getToeflQuestions(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ToeflQuestion::className(), ['exam_id' => 'id']);
    }

    public function getFileUrl($type = "thumb"): string
    {
        return $this->img ? Yii::$app->urlManager->hostInfo . '/uploads/english-exam' . '/' . $this->id . '/' . $this->img : '';
    }

    //</editor-fold>

//    public function prepareQuestionListeningToefl()
//    {
//        $required_count = 30;
//        $subQuery = (new \yii\db\Query())
//            ->from(['question' => ToeflQuestion::tableName()])
//            ->select([
//                'question.listening_group_id',
//                'count(*) as count'
//            ])
//            ->groupBy('question.listening_group_id');
//
//        $queryA = ListeningGroup::find()
//            ->with(['toeflQuestion', 'toeflQuestion.toeflOptions'])
//            ->andWhere(['type_id' => ListeningGroup::TEST_TYPE_ID_A])
//            ->alias('listening_group')
//            ->andWhere(['exam_id' => $this->id])
//            ->leftJoin(['questionTable' => $subQuery], 'questionTable.listening_group_id = listening_group.id')
//            ->orderBy('rand()')
//            ->limit(10); // randomize the results
//
//        $queryB = ListeningGroup::find()
//            ->with(['toeflQuestion', 'toeflQuestion.toeflOptions'])
//            ->andWhere(['type_id' => ListeningGroup::TEST_TYPE_ID_B])
//            ->alias('listening_group')
//            ->andWhere(['exam_id' => $this->id])
//            ->leftJoin(['questionTable' => $subQuery], 'questionTable.listening_group_id = listening_group.id')
//            ->orderBy('rand()')
//            ->limit(4); // randomize the results
//
//        $queryC = ListeningGroup::find()
//            ->with(['toeflQuestion', 'toeflQuestion.toeflOptions'])
//            ->andWhere(['type_id' => ListeningGroup::TEST_TYPE_ID_C])
//            ->alias('listening_group')
//            ->andWhere(['exam_id' => $this->id])
//            ->leftJoin(['questionTable' => $subQuery], 'questionTable.listening_group_id = listening_group.id')
//            ->orderBy('rand()')
//            ->limit(6); // randomize the results
//
//        $accumulatedGroups = [];
//        $totalQuestions = 0;
//
//        $queries = [$queryA, $queryB, $queryC];
//
//        foreach ($queries as $query) {
//            foreach ($query->each() as $group) {
//                $questionCount = $group->questionTable['count'] ?? 0;
//                $totalQuestions += $questionCount;
//                $accumulatedGroups[] = $group;
//
//                if ($totalQuestions >= $required_count) {
//                    break 2; // Break out of both loops
//                }
//            }
//        }
//
//        return $accumulatedGroups;
//    }
    public function prepareQuestionListeningToefl()
    {
        $queryA = ListeningGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => ListeningGroup::TEST_TYPE_ID_A])
            ->all();
        $queryB = ListeningGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => ListeningGroup::TEST_TYPE_ID_B])
            ->all();
        $queryC = ListeningGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => ListeningGroup::TEST_TYPE_ID_C])
            ->all();
        return array_merge($queryA, $queryB, $queryC);
    }

    public function prepareQuestionWritingToefl()
    {
        $question_a = ToeflQuestion::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => ToeflQuestion::TYPE_WRITING])
            ->andWhere(['status' => ToeflQuestion::STATUS_ACTIVE])
            ->andWhere(['test_type_id' => ToeflQuestion::ABC_TYPE_ID_A])
            ->limit(15)
            ->all();
        $question_b = ToeflQuestion::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => ToeflQuestion::TYPE_WRITING])
            ->andWhere(['status' => ToeflQuestion::STATUS_ACTIVE])
            ->andWhere(['test_type_id' => ToeflQuestion::ABC_TYPE_ID_B])
            ->limit(25)
            ->all();
        return array_merge($question_a, $question_b);
    }

    public function prepareQuestionReadingToefl()
    {
        return ToeflReadingGroup::find()
            ->andWhere([
                'exam_id' => $this->id,
            ])
            ->all();
    }

    public function prepareQuestionListeningIelts()
    {
        $query1 = IeltsQuestionGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_LISTENING])
            ->andWhere(['section' => IeltsQuestionGroup::SECTION_1])
            ->all();
        $query2 = IeltsQuestionGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_LISTENING])
            ->andWhere(['section' => IeltsQuestionGroup::SECTION_2])
            ->all();
        $query3 = IeltsQuestionGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_LISTENING])
            ->andWhere(['section' => IeltsQuestionGroup::SECTION_3])
            ->all();
        $query4 = IeltsQuestionGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_LISTENING])
            ->andWhere(['section' => IeltsQuestionGroup::SECTION_4])
            ->all();
        return array_merge($query1, $query2, $query3, $query4);
    }

    public function prepareQuestionReadingIelts(): array
    {
        $query1 = IeltsQuestionGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_READING])
            ->andWhere(['section' => IeltsQuestionGroup::SECTION_1])
            ->all();
        $query2 = IeltsQuestionGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_READING])
            ->andWhere(['section' => IeltsQuestionGroup::SECTION_2])
            ->all();
        $query3 = IeltsQuestionGroup::find()
            ->andWhere(['exam_id' => $this->id])
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_READING])
            ->andWhere(['section' => IeltsQuestionGroup::SECTION_3])
            ->all();
        return array_merge($query1, $query2, $query3);
    }

    public function prepareQuestionWritingIelts()
    {
        $query = IeltsQuestions::find()
            ->andWhere(['=', 'group_type', IeltsQuestions::TYPE_WRITING_GROUP])
            ->andWhere(['exam_id' => $this->id]);
        return $query->all();
    }

    public function prepareQuestionSpeakingIelts()
    {
        $query = IeltsQuestions::find()
            ->andWhere(['=', 'group_type', IeltsQuestions::TYPE_SPEAKING_GROUP])
            ->andWhere(['exam_id' => $this->id]);
        return $query->all();
    }
}
