<?php

/* @var $this soft\web\View */
/* @var $content string */

use soft\widget\Alert;
use yii\bootstrap4\Breadcrumbs;


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="col-sm-12">

                <?= Breadcrumbs::widget([
                    'links' => $this->params['breadcrumbs'] ?? []
                ]) ?>

            </div>

            <?php if (!empty(Yii::$app->session->getAllFlashes())): ?>
                <div class="col-sm-12 mt-2 mb-2">
                    <?= Alert::widget() ?>
                </div>
            <?php endif ?>

        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?= $content ?>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
