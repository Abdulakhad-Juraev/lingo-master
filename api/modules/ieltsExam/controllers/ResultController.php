<?php

namespace api\modules\ieltsExam\controllers;

use api\controllers\ApiBaseController;
use api\modules\ieltsExam\models\IeltsResult;
use api\modules\ieltsExam\models\IeltsResultItem;
use common\modules\ieltsExam\models\IeltsQuestions;
use common\modules\ieltsExam\models\search\IeltsResultSearch;

class ResultController extends ApiBaseController
{
    public $authRequired = true;

    public function actionIndex()
    {
        $query = IeltsResult::find()
            ->andWhere(['user_id' => \Yii::$app->user->getId()])
            ->andWhere(['step' => IeltsResult::STEP_FINISHED])
            ->orderBy('id DESC');
        $searchModel = new IeltsResultSearch();
        $dataProvider = $searchModel->search($query);
        return $this->success($dataProvider);
    }

    public function actionScore($id)
    {
        /** @var IeltsResult $result */
        $result = IeltsResult::find()
            ->andWhere(['id' => $id])
            ->andWhere(['user_id' => \Yii::$app->user->identity->getId()])
            ->one();
        if (!$result) {
            return $this->error('Result topilmadi');
        }
        $score = [
            'id' => $result->id,
            'title' => $result->exam->title,
            'result' => $result->ieltsBandScore . '/9',
            'start_date' => $result->started_at,
            'finished_date' => $result->finished_at,
            'finishedDateFormat' => \Yii::$app->formatter->asDatetime($result->finished_at, 'php:Y-m-d H:i:s'),
            'listening' => [
                'score' => $result->listening_score . '/9',
                'parts' => [
                    'part_1' => $this->countCorrectAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_1_name' => 'Section1 - Short Conversations',
                    'part_2' => $this->countCorrectAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_2_name' => 'Section2 - Monologue',
                    'part_3' => $this->countCorrectAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_3_name' => 'Section3- Long Conversation',
                    'part_4' => $this->countCorrectAnswers(IeltsQuestions::SECTION_4, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_4_name' => 'Section4- Lecture',
                ]
            ],
            'reading' => [
                'score' => $result->reading_score . '/9',
                'parts' => [
                    'part_1' => $this->countCorrectAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_READING) . '/14',
                    'part_1_name' => 'Section1 - First Text',
                    'part_2' => $this->countCorrectAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_READING) . '/14',
                    'part_2_name' => 'Section2 - Second Text',
                    'part_3' => $this->countCorrectAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_READING) . '/12',
                    'part_3_name' => 'Section3- Third Text',
                ]
            ],
            'writing' => [
                'score' => $result->writing_score . '/9',
                'parts' => [
                    'part_1' => $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_WRITING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_WRITING),
                    'part_1_name' => 'Section1 - Short Essay',
                    'part_2' => $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_WRITING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_WRITING),
                    'part_2_name' => 'Section2 - Long Essay',
                ]
            ],
            'speaking' => [
                'score' => $result->speaking_score . '/9',
                'parts' => [
                    'part_1' => $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_SPEAKING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_SPEAKING),
                    'part_1_name' => 'Part1 - Introduction and interview',
                    'part_2' => $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_SPEAKING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_SPEAKING),
                    'part_2_name' => 'Part2 - Individual Long Turn',
                    'part_3' => $this->countAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_SPEAKING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_SPEAKING),
                    'part_3_name' => 'Part3 - Two-way Discussion',
                ]
            ],
        ];
        return $this->success($score);

    }

    public function actionDetail($id)
    {

        /** @var IeltsResult $result */
        $result = IeltsResult::find()
            ->andWhere(['id' => $id])
            ->andWhere(['user_id' => \Yii::$app->user->identity->getId()])
            ->one();
        if (!$result) {
            return $this->error('Result topilmadi');
        }
        $score = [
            'id' => $result->id,
            'title' => $result->exam->title,
            'result' => $result->ieltsBandScore . '/9',
            'start_date' => $result->started_at,
            'finished_date' => $result->finished_at,
            'listening' => [
                'score' => $result->listening_score . '/9',
                'parts' => [
                    'part_1' => $this->countCorrectAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_1_name' => 'Section1 - Short Conversations',
                    'part_2' => $this->countCorrectAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_2_name' => 'Section2 - Monologue',
                    'part_3' => $this->countCorrectAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_3_name' => 'Section3- Long Conversation',
                    'part_4' => $this->countCorrectAnswers(IeltsQuestions::SECTION_4, $result->id, IeltsResultItem::TYPE_LISTENING) . '/10',
                    'part_4_name' => 'Section4- Lecture',
                ]
            ],
            'reading' => [
                'score' => $result->reading_score . '/9',
                'parts' => [
                    'part_1' => $this->countCorrectAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_READING) . '/14',
                    'part_1_name' => 'Section1 - First Text',
                    'part_2' => $this->countCorrectAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_READING) . '/14',
                    'part_2_name' => 'Section2 - Second Text',
                    'part_3' => $this->countCorrectAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_READING) . '/12',
                    'part_3_name' => 'Section3- Third Text',
                ]
            ],
            'writing' => [
                'score' => $result->writing_score . '/9',
                'parts' => [
                    'part_1' => $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_WRITING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_WRITING),
                    'part_1_name' => 'Section1 - Short Essay',
                    'part_2' => $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_WRITING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_WRITING),
                    'part_2_name' => 'Section2 - Long Essay',
                ]
            ],
            'speaking' => [
                'score' => $result->speaking_score . '/9',
                'parts' => [
                    'part_1' => $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_SPEAKING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_1, $result->id, IeltsResultItem::TYPE_SPEAKING),
                    'part_1_name' => 'Part1 - Introduction and interview',
                    'part_2' => $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_SPEAKING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_2, $result->id, IeltsResultItem::TYPE_SPEAKING),
                    'part_2_name' => 'Part2 - Individual Long Turn',
                    'part_3' => $this->countAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_SPEAKING) . '/' . $this->countAnswers(IeltsQuestions::SECTION_3, $result->id, IeltsResultItem::TYPE_SPEAKING),
                    'part_3_name' => 'Part3 - Two-way Discussion',
                ]
            ],
            'questions' => IeltsResultItem::find()->select(['id', 'is_correct'])->andWhere(['result_id' => $result->id])->asArray()->all()
        ];
        return $this->success($score);
    }

    public function actionResultItemDetail($id)
    {
        /** @var IeltsResultItem $resultItem */
        $resultItem = IeltsResultItem::find()
            ->with(['result', 'question'])
            ->joinWith('result')
            ->andWhere(['ielts_result.user_id' => \Yii::$app->user->getId()])
            ->andWhere(['ielts_result_item.id' => $id])
            ->one();
        if ($resultItem === null) {
            // Handle the case where $resultItem is not found
            return $this->error('Result item not found.');
        }
        $response = [
            'id' => $resultItem->id,
            'question_id' => $resultItem->question_id,
            'options' => $resultItem->question->ieltsOptions,
            'user_answer_id' => $resultItem->user_answer_id,
            'is_correct' => $resultItem->is_correct,
            'original_answer_id' => $resultItem->original_answer_id,
            'type_id' => $resultItem->type_id
        ];
        switch ($resultItem->type_id) {
            case IeltsResultItem::TYPE_READING:
                $response['value'] = $resultItem->question->questionGroup->content ?? '';
                break;
            case IeltsResultItem::TYPE_LISTENING:
                $response['value'] = $resultItem->question->questionGroup->getAudioUrl() ?? '';
                break;
            case IeltsResultItem::TYPE_WRITING:
            case IeltsResultItem::TYPE_SPEAKING:
                $response['value'] = '';
                break;
            default:
                return $this->error('Unknown type.');
        }
        switch ($resultItem->input_type) {
            case IeltsResultItem::INPUT_TYPE_RADIO:
            case IeltsResultItem::INPUT_TYPE_TEXT:
                $response['question'] = $resultItem->question->value ?? '';
                break;
            case IeltsResultItem::INPUT_TYPE_AUDIO:
                $response['question'] = $resultItem->question->getAudioUrl() ?? '';
                break;
            default:
                return $this->error('Unknown type.');
        }
        return $this->success($response);
    }

    public function countCorrectAnswers($section, $resultId, $resultItemTypeId)
    {
        return IeltsResultItem::find()
            ->alias('tri')
            ->innerJoinWith(['question tq', 'question.questionGroup qg'])
            ->andWhere([
                'qg.section' => $section,
                'tri.type_id' => $resultItemTypeId,
                'tri.result_id' => $resultId,
                'tri.is_correct' => 1
            ])
            ->count();
    }


    public function countAnswers($section, $resultId, $resultItemTypeId)
    {
        return IeltsResultItem::find()
            ->alias('tri')
            ->joinWith('question tq', false)
            ->where([
                'tq.section' => $section,
                'tri.type_id' => $resultItemTypeId,
                'tri.result_id' => $resultId
            ])
            ->count();
    }
}