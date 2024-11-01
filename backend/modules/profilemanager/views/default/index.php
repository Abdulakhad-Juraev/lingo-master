<?php

use soft\widget\bs4\DetailView;
use yii\helpers\Url;
use soft\widget\adminlte3\Card;

/** @var \soft\web\View $this */

$this->title = 'Shaxsiy kabinet';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="profilemanager-default-index row">
    <div class="col-md-6">
        <?php Card::begin()  ?>

        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="<?= Yii::$app->user->identity->photoUrl ?>"
                 alt="User profile picture">
        </div>
        <h1><?= $this->title ?></h1>
        <p>
            <a href="<?= Url::to(['change-login']) ?>" class="btn btn-primary">
                <i class="fa fa-edit"></i>Shaxsiy ma'lumotlarni o'zgartirish
            </a>
            <a href="<?= Url::to(['change-password']) ?>" class="btn btn-danger">
                <i class="fa fa-key"></i> <?= "Parolni o'zgartirish" ?>
            </a>
        </p>
         <div class="row">
             <div class="col-md-12">
                 <?= DetailView::widget([
                     'model' => user(),
                     'attributes' => [
                         'username:text:Login',
                         'firstname:text:Ism',
                         'lastname:text:Familiya',
                     ]
                 ]) ?>
             </div>
         </div>
        <?php Card::end()  ?>
    </div>

</div>
