<?php

namespace api\controllers;

use api\models\CompanyInfo;
use api\models\Faq;
use api\models\Subject;
use api\models\TestList;
use common\models\Instructions;
use common\models\UniversityStatistics;
use common\modules\testmanager\models\search\SubjectSearch;

class OpenDataController extends ApiBaseController
{
    public $authRequired = false;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

//    public function actionSubject(): array
//    {
//        $searchModel = new SubjectSearch();
//        $dataProvider = $searchModel->search(Subject::find());
//        return $this->success($dataProvider);
//    }
    public function actionUniversityStatistics(): array
    {
        $array = [
            [
                'name' => t('Student'),
                'count' => UniversityStatistics::studentsCount(),
            ],
            [
                'name' => t('Test'),
                'count' => UniversityStatistics::testsCount(),
            ],
        ];
        return $this->success($array);
    }

    public function actionFaq(): array
    {
        Faq::setFields([
            'id',
            'label' => function (Faq $model) {
                return $model->question;
            },
            'content' => function (Faq $model) {
                return $model->answer;
            }
        ]);
        return $this->success(Faq::find()->all());
    }

    public function actionCompanyInfo(): array
    {
        $data = CompanyInfo::find()
            ->active()
            ->one();

        return $this->success($data);
    }

    public function actionTestList(): array
    {
        $data = TestList::find()
            ->active()
            ->all();
        return $this->success($data);
    }

    public function actionInstruction($type_id, $exam_type_id): array
    {
        Instructions::setFields([
            'content',
        ]);
        return $this->success(Instructions::find()->andWhere(['type_id' => $type_id, 'exam_type_id' => $exam_type_id])->one());
    }

}