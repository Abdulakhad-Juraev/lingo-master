<?php

namespace common\modules\testmanager\controllers;

use common\models\ImportExcel;
use common\modules\testmanager\models\TestResult;
use frontend\web\controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Yii;
use common\modules\testmanager\models\Test;
use common\modules\testmanager\models\search\TestSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * SubjectController implements the CRUD actions for Subject model.
 */
class TestController extends BaseController
{


    /**
     * Lists all Subject models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Test::find()->andWhere(['!=', 'status', Test::STATUS_DELETED]);
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subject model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Subject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Test();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Subject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->started_at = $model->started_at ? Yii::$app->formatter->asDatetime($model->started_at, 'php:Y-m-d H:i') : $model->started_at;
        $model->finished_at = $model->finished_at ? Yii::$app->formatter->asDatetime($model->finished_at, 'php:Y-m-d H:i') : $model->finished_at;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Subject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $exists = TestResult::find()->andWhere(['status' => TestResult::STATUS_ACTIVE])->exists();
        if ($exists) {
            Yii::$app->session->setFlash('error', 'Fao test mavjud');
        } else {
            $model->status = TestResult::STATUS_DELETED;
            $model->save();
        }
        return $this->redirect(['index']);

    }

    public function actionImport($id)
    {
        $model = new ImportExcel();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $model->file->saveAs('@frontend/web/uploads/excelFile/' . $model->file->baseName . '.' . $model->file->extension);
                $fileName = Yii::getAlias('@frontend/web/uploads/excelFile/') . $model->file->baseName . '.' . $model->file->extension;
                $fileType = $model->file->extension;
                $errors = $model->getImportFromExcel($fileName, $fileType, $id);
                Yii::$app->session->setFlash('errors', $errors);
                return $this->redirect(['question/index', 'test_id' => $id]);
            }
        }
        return $this->render('import', [
            'model' => $model,
        ]);
    }

    public function actionExport($id): void
    {
        $test = Test::findModel($id);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Foydalanuvchi')->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('B1', 'Test soni')->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('C1', 'To\'g\'ri javoblar')->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('D1', 'Yeg\'gan bali')->getStyle('D1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('E1', 'Boshlagan vaqti')->getStyle('E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('F1', 'Tugagan vaqti')->getStyle('F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $results = $test->results;
        if (!empty($results)) {
            /** @var TestResult $result */
            foreach ($results as $key => $result) {
                $sheet->setCellValue('A' . ($key + 2), $result->user->full_name)->getStyle('A' . ($key + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('B' . ($key + 2), $result->tests_count)->getStyle('B' . ($key + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('C' . ($key + 2), $result->correct_answers)->getStyle('C' . ($key + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('D' . ($key + 2), $result->score)->getStyle('D' . ($key + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('E' . ($key + 2), Yii::$app->formatter->asDatetime($result->started_at, 'php:d.m.Y H:i:s'))->getStyle('E' . ($key + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('F' . ($key + 2), Yii::$app->formatter->asDatetime($result->finished_at, 'php:d.m.Y H:i:s'))->getStyle('F' . ($key + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            }
        }
        // Width ni belgilash
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $file_path = $test->name . '.xlsx'; // Faylning saqlanishi kerak bo'lgan manzilni belgilash
        $writer->save($file_path);
        // Faylni yuklash uchun mos yo'l.


        // Faylni yuklash
        if (file_exists($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            unlink($file_path);
            exit;
        } else {
            echo 'Fayl topilmadi.';
        }
    }


    /**
     * Finds the Subject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->status == Test::STATUS_ACTIVE) {
            $model->status = Test::STATUS_INACTIVE;
        } else {
            $model->status = Test::STATUS_ACTIVE;
        }
        $model->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }
}
