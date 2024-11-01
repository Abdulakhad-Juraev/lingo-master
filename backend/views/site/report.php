<?php

use common\models\Report;
use common\models\User;
use common\modules\usermanager\models\UserPayment;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model */
/* @var $dates [] */


$this->title = t('Reports');

$allData = [];
$month = $dates['month'];
$year = $dates['year'];

$beginDate = "01." . $month . '.' . $year;

$beginDay = date('d', strtotime($beginDate));
$endDay = date('t', strtotime($beginDate));
$endDate = $endDay . '.' . $month . '.' . $year;

$createdUsers = User::find()
    ->andWhere(['>=', 'created_at', strtotime($beginDate)])
    ->andWhere(['<=', 'created_at', strtotime($endDate)])
    ->all();

$userPaymentSums = UserPayment::find()
    ->andWhere(['>=', 'created_at', strtotime($beginDate)])
    ->andWhere(['<=', 'created_at', strtotime($endDate)])
    ->andWhere(['>', 'amount', 0])
//    ->andWhere(['=', 'type_id', 'cash'])
//    ->andWhere(['=', 'type_id', 'card'])
//    ->andWhere(['=', 'type_id', 'click'])
//    ->andWhere(['=', 'type_id', 'payme'])
//    ->andWhere(['=', 'type_id', 'paynet'])
    ->all();

$allUserCount = 0;
$allUserPaymentTotalSum = 0;
$allUserPaymentTotalCount = 0;

for ($i = 1; $i <= $endDay; $i++) {

    $clientCount = 0;
    $userPaymentTotalSum = 0;
    $userPaymentTotalCount = 0;

    foreach ($createdUsers as $createdUser) {
        if (date('d.m.Y', $createdUser->created_at) === date('d.m.Y', strtotime($i . '.' . $month . '.' . $year))) {
            $clientCount++;
        }
    }
    foreach ($userPaymentSums as $userPaymentSum) {
        if (date('d.m.Y', $userPaymentSum->created_at) === date('d.m.Y', strtotime($i . '.' . $month . '.' . $year))) {
            $userPaymentTotalSum += $userPaymentSum->amount;
            $userPaymentTotalCount++;
        }
    }

    $allUserCount += $clientCount;
    $allUserPaymentTotalCount += $userPaymentTotalCount;
    $allUserPaymentTotalSum += $userPaymentTotalSum;

    $allData[] = [
        $i . '-' . $month . '-' . $year => [
            'clientCount' => $clientCount,
            'userPaymentTotalSum' => $userPaymentTotalSum,
            'userPaymentTotalCount' => $userPaymentTotalCount,
        ],
    ];
}
//dd($allData);
?>
<div class="card direct-chat direct-chat-primary">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title"><i class="fas fa-search"></i> Qidiruv</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="display: block">
        <?php $form = ActiveForm::begin() ?>
        <div class="row ml-2">
            <div class="col-md-4">
                <?= $form->field($model, 'year')->textInput(['placeholder' => date('Y')]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'month')->dropDownList(Report::months(), ['prompt' => "Oyni tanlang..."]); ?>
            </div>
            <div class="col-md-4" style="margin-top: 28px">
                <?= Html::submitButton('<i class="fas fa-search"></i> Qidiruv') ?>
                <?= Html::a('<i class="fas fa-file-export"></i> Excelga yuklash', ['#'], ['class' => 'btn btn-warning', 'id' => 'downloadLink', 'onclick' => 'exportF(this)']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>

</div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped" id="myTable">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Sana</th>
                <th scope="col">Ro'yhatdan o'tganlar soni</th>
                <th scope="col">To'lovlar miqdori</th>
                <th scope="col">To'lov qilganlar soni</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 1; $i <= $endDay; $i++): ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $i . '-' . $month . '-' . $year ?></td>
                    <td><?= $allData[$i - 1][$i . '-' . $month . '-' . $year]['clientCount'] ?></td>
                    <td><?= Yii::$app->formatter->asInteger($allData[$i - 1][$i . '-' . $month . '-' . $year]['userPaymentTotalSum']) ?>
                        so'm
                    </td>
                    <td><?= $allData[$i - 1][$i . '-' . $month . '-' . $year]['userPaymentTotalCount'] ?></td>
                </tr>
            <?php endfor; ?>
            <tr>
                <td>#</td>
                <td><b>Jami:</b></td>
                <td><b><?= $allUserCount ?></b></td>
                <td><b><?= Yii::$app->formatter->asInteger($allUserPaymentTotalSum) ?></b> so'm</td>
                <td><b><?= $allUserPaymentTotalCount ?></b></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function exportF(elem) {
        var table = document.getElementById("myTable");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel,' + '\uFEFF' + encodeURIComponent(html); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "<?=$month . '-' . $year?>.xls"); // Choose the file name
        return false;
    }
</script>
