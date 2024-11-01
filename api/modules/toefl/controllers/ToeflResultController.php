<?php

namespace api\modules\toefl\controllers;

use api\controllers\ApiBaseController;
use api\modules\englishExam\models\IeltsResult;
use api\modules\toefl\models\ListeningGroup;
use api\modules\toefl\models\ToeflQuestion;
use api\modules\toefl\models\ToeflResult;
use api\modules\toefl\models\ToeflResultItem;
use common\modules\toeflExam\models\search\ToeflResultSearch;
use common\modules\toeflExam\models\ToeflListeningGroup;

class ToeflResultController extends ApiBaseController
{
    public $authRequired = true;

    public function actionIndex()
    {
        $query = ToeflResult::find()
            ->andWhere(['user_id' => \Yii::$app->user->getId()])
            ->andWhere(['step' => ToeflResult::STEP_FINISHED])
            ->orderBy('id DESC');
        $searchModel = new ToeflResultSearch();
        $dataProvider = $searchModel->search($query);
        return $this->success($dataProvider);
    }

    public function actionScore($id)
    {
        /** @var ToeflResult $result */
        $result = ToeflResult::find()
            ->andWhere(['id' => $id])
            ->andWhere(['user_id' => \Yii::$app->user->identity->getId()])
            ->one();
        if (!$result) {
            return $this->error('Result topilmadi');
        }
        $score = [
            'id' => $result->id,
            'title' => $result->exam->title,
            'result' => $result->toeflResult . '/677',
            'start_date' => $result->started_at,
            'finished_date' => $result->finished_at,
            'listening' => [
                'score' => $result->listening_score . '/68',
                'parts' => [
                    'part_a' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_A, $result->id, ToeflResultItem::TYPE_LISTENING) . '/30',
                    'part_a_name' => 'Part A - Short Conversations',
                    'part_b' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_B, $result->id, ToeflResultItem::TYPE_LISTENING) . '/8',
                    'part_b_name' => 'Part B - Long conversations',
                    'part_c' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_C, $result->id, ToeflResultItem::TYPE_LISTENING) . '12',
                    'part_c_name' => 'Part C - Lectures',
                ]
            ],
            'writing' => [
                'score' => $result->writing_score . '/68',
                'parts' => [
                    'part_a' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_A, $result->id, ToeflResultItem::TYPE_WRITING) . '/15',
                    'part_a_name' => 'Sentence Completion',
                    'part_b' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_B, $result->id, ToeflResultItem::TYPE_WRITING) . '/15',
                    'part_b_name' => 'Part 2 - Error identification',
                ]
            ],
            'reading' => [
                'score' => $result->reading_score . '/67',
                'parts' => [
                    'part' => ToeflResultItem::find()
                            ->alias('tri')
                            ->andWhere(['tri.type_id' => ToeflResultItem::TYPE_READING])
                            ->andWhere(['tri.result_id' => $result->id])
                            ->andWhere(['tri.is_correct' => 1])
                            ->count() . '/50',
                    'part_a_name' => 'Passages'
                ],
            ],
        ];
        return $this->success($score);

    }

    public function countCorrectAnswers($typeId, $resultId, $resultItemTypeId)
    {
        return ToeflResultItem::find()
            ->alias('tri')
            ->joinWith('question tq')
            ->andWhere(['tq.type_id' => $typeId])
            ->andWhere(['tri.type_id' => $resultItemTypeId])
            ->andWhere(['tri.result_id' => $resultId])
            ->andWhere(['tri.is_correct' => 1])
            ->count();
    }

    public function actionDetail($id)
    {

        /** @var ToeflResult $result */
        $result = ToeflResult::find()
            ->andWhere(['id' => $id])
            ->andWhere(['user_id' => \Yii::$app->user->identity->getId()])
            ->one();
        if (!$result) {
            return $this->error('Result topilmadi');
        }
        $score = [
            'id' => $result->id,
            'title' => $result->exam->title,
            'result' => $result->toeflResult . '/677',
            'start_date' => $result->started_at,
            'finished_date' => $result->finished_at,
            'finishedDateFormat' => \Yii::$app->formatter->asDatetime($result->finished_at, 'php:Y-m-d H:i:s'),
            'listening' => [
                'score' => $result->listening_score . '/68',
                'parts' => [
                    'part_a' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_A, $result->id, ToeflResultItem::TYPE_LISTENING) . '/30',
                    'part_a_name' => 'Part A - Short Conversations',
                    'part_b' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_B, $result->id, ToeflResultItem::TYPE_LISTENING) . '/8',
                    'part_b_name' => 'Part B - Long conversations',
                    'part_c' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_C, $result->id, ToeflResultItem::TYPE_LISTENING) . '12',
                    'part_c_name' => 'Part C - Lectures',
                ]
            ],
            'writing' => [
                'score' => $result->writing_score . '/68',
                'parts' => [
                    'part_a' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_A, $result->id, ToeflResultItem::TYPE_WRITING) . '/15',
                    'part_a_name' => 'Sentence Completion',
                    'part_b' => $this->countCorrectAnswers(ToeflQuestion::ABC_TYPE_ID_B, $result->id, ToeflResultItem::TYPE_WRITING) . '/15',
                    'part_b_name' => 'Part 2 - Error identification',
                ]
            ],
            'reading' => [
                'score' => $result->reading_score . '/67',
                'parts' => [
                    'part' => ToeflResultItem::find()
                            ->alias('tri')
                            ->andWhere(['tri.type_id' => ToeflResultItem::TYPE_READING])
                            ->andWhere(['tri.result_id' => $result->id])
                            ->andWhere(['tri.is_correct' => 1])
                            ->count() . '/50',
                    'part_a_name' => 'Passages'
                ],
            ],
            'questions' => ToeflResultItem::find()->select(['id', 'is_correct'])->andWhere(['result_id' => $result->id])->asArray()->all()

        ];
        return $this->success($score);
    }

    public function actionResultItemDetail($id)
    {
        /** @var ToeflResultItem $resultItem */
        $resultItem = ToeflResultItem::find()
            ->with(['result', 'question', 'question.readingGroup', 'listeningGroup'])
            ->joinWith('result')
            ->andWhere(['toefl_result.user_id' => \Yii::$app->user->getId()])
            ->andWhere(['toefl_result_item.id' => $id])
            ->one();
        if ($resultItem === null) {
            // Handle the case where $resultItem is not found
            return $this->error('Result item not found.');
        }
        $response = [
            'id' => $resultItem->id,
            'question' => $resultItem->question->value,
            'question_id' => $resultItem->question_id,
            'options' => $resultItem->question->toeflOptions,
            'user_answer_id' => $resultItem->user_answer_id,
            'is_correct' => $resultItem->is_correct,
            'original_answer_id' => $resultItem->original_answer_id,
            'type_id' => $resultItem->type_id
        ];
        switch ($resultItem->type_id) {
            case ToeflResultItem::TYPE_READING:
                $response['value'] = $resultItem->question->readingGroup->text;
                break;
            case ToeflResultItem::TYPE_LISTENING:
                $response['value'] = $resultItem->question->listeningGroup->getAudioUrl();
                break;

            case ToeflResultItem::TYPE_WRITING:
                $response['value'] = '';
                break;
            default:
                // Handle unknown type_id if necessary
                return $this->error('Unknown type.');
        }

        return $this->success($response);
    }
}