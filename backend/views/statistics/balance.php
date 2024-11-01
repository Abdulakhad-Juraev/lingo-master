<?php

/**
 * @var $this \yii\web\View
 * @var $from_date string
 * @var $to_date string
 * @var $balanceIncome int
 * @var $balanceExpense int
 * @var $balance array
 */

use frontend\assets\AppAsset;
use kartik\date\DatePicker;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

$this->registerAjaxCrudAssets();

$this->title = 'Balans';
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="row d-flex justify-content-center">
        <div class="col-auto">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="form-inline">
                            <?php
                            echo DatePicker::widget([
                                'name' => 'from_date',
                                'value' => $from_date,
                                'type' => DatePicker::TYPE_RANGE,
                                'name2' => 'to_date',
                                'value2' => $to_date,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy'
                                ],
                            ]);

                            echo Html::submitButton("Ko'rish", [
                                'class' => 'btn btn-primary ml-2',
                            ]);
                            ?>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
            <span class="info-box-icon bg-success">
                <i class="fa fa-plus"></i>
            </span>
                <div class="info-box-content">
                    <span class="info-box-text">To'lov qilindi</span>
                    <span class="info-box-number">
                    <?= Yii::$app->formatter->asInteger($balanceIncome) ?>
                </span>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
            <span class="info-box-icon bg-danger">
                <i class="fa fa-minus"></i>
            </span>
                <div class="info-box-content">
                    <span class="info-box-text">To'lov olindi</span>
                    <span class="info-box-number">
                    <?= Yii::$app->formatter->asInteger($balanceExpense) ?>
                </span>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
            <span class="info-box-icon bg-primary">
                <i class="fa fa-hand-holding-dollar"></i>
            </span>
                <div class="info-box-content">
                    <span class="info-box-text">Jami</span>
                    <span class="info-box-number">
                    <?= Yii::$app->formatter->asInteger($balanceIncome - $balanceExpense) ?>
                </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Diagramma
                    </h3>
                </div>
                <div class="card-body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Hisobot
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ismi</th>
                            <th scope="col">+</th>
                            <th scope="col">-</th>
                            <th scope="col">Jami</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($balance as $row): ?>
                            <tr>
                                <th scope="row"><?= isset($i) ? ++$i : $i = 1 ?></th>
                                <td>
                                    <?= $row['user'] ?>
                                </td>
                                <td>
                                    <?= Yii::$app->formatter->asInteger($row['in']) ?>
                                </td>
                                <td>
                                    <?= Yii::$app->formatter->asInteger($row['out']) ?>
                                </td>
                                <td>
                                    <?= Yii::$app->formatter->asInteger($row['total']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2">
                                Jami:
                            </td>
                            <td>
                                <?= Yii::$app->formatter->asInteger(array_sum(ArrayHelper::getColumn($balance, 'in'))) ?>
                            </td>
                            <td>
                                <?= Yii::$app->formatter->asInteger(array_sum(ArrayHelper::getColumn($balance, 'out'))) ?>
                            </td>
                            <td>
                                <?= Yii::$app->formatter->asInteger(array_sum(ArrayHelper::getColumn($balance, 'total'))) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
$values = json_encode(ArrayHelper::getColumn($balance, 'total'), JSON_THROW_ON_ERROR);
$labels = json_encode(ArrayHelper::getColumn($balance, 'user'), JSON_THROW_ON_ERROR);
//var_dump($balance);
//exit();
$js = <<<JS
  var options = {
          series: ${values},
          chart: {
          type: 'donut',
        },
        labels: ${labels},
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
JS;

$this->registerJs($js);