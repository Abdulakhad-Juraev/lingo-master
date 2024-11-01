<?php

namespace common\modules\ieltsExam\models\traits;


use common\modules\ieltsExam\models\IeltsOptions;
use Exception;
use soft\helpers\ArrayHelper;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

trait IeltsQuestionDynamicFormTrait
{
    /**
     * @param array $modelsOptions
     * @return bool
     * @throws InvalidConfigException
     */
    public function insertMultiple(array $modelsOptions = []): bool
    {
        $modelsOptions = $this->createMultiple($modelsOptions);
        Model::loadMultiple($modelsOptions, Yii::$app->request->post());
        $valid = $this->validate();
        $valid = Model::validateMultiple($modelsOptions) && $valid;
        if ($valid) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($flag = $this->save(false)) {

                    $isAnswerKey = Yii::$app->request->post('is_correct');
                    foreach ($modelsOptions as $key => $modelOption) {

                        $modelOption->is_correct = $key == $isAnswerKey;
                        $modelOption->question_id = $this->id;
                        if (!($flag = $modelOption->save(false))) {
                            dd($valid);

                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return true;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        return false;
    }

    /**
     * @param $modelsOption IeltsOptions[]
     * @return bool
     * @throws InvalidConfigException
     */
    public function updateMultiple($modelsOption): bool
    {
        $oldIDs = ArrayHelper::map($modelsOption, 'id', 'id');
        $modelsOption = $this->createMultiple($modelsOption);
        Model::loadMultiple($modelsOption, Yii::$app->request->post());

        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsOption, 'id', 'id')));

        // validate all models
        $valid = $this->validate();
        $valid = Model::validateMultiple($modelsOption) && $valid;

        if ($valid) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($flag = $this->save(false)) {
                    if (!empty($deletedIDs)) {
                        IeltsOptions::deleteAll(['id' => $deletedIDs]);
                    }

                    $isAnswerKey = Yii::$app->request->post('is_correct');

                    foreach ($modelsOption as $key => $modelOption) {
                        $modelOption->is_correct = $key == $isAnswerKey;
                        $modelOption->question_id = $this->id;
                        if (!($flag = $modelOption->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return true;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return false;
    }

    /**
     * @param IeltsOptions[] $optionModels
     * @return IeltsOptions[]
     * @throws InvalidConfigException
     */
    public function createMultiple($optionModels = []): array
    {
        $model = new IeltsOptions();
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (!empty($optionModels)) {
            $keys = array_keys(ArrayHelper::map($optionModels, 'id', 'id'));
            $optionModels = array_combine($keys, $optionModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['id']) && !empty($item['id']) && isset($optionModels[$item['id']])) {
                    $models[] = $optionModels[$item['id']];
                } else {
                    $models[] = new IeltsOptions();
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }

}