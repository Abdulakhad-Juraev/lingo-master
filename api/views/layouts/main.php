<?php

use frontend\assets\AppAsset;
use soft\helpers\SiteHelper;
use soft\helpers\Url;
use soft\helpers\Html;
use yii\bootstrap4\Alert;

/* @var $this \soft\web\View */
/* @var $content string */

AppAsset::register($this);

$title = $this->metaTitle ?? SiteHelper::siteTitle();
$description = $this->metaDescription ?? SiteHelper::siteDescription();
$keywords = $this->metaKeywords ?? SiteHelper::siteKeywords();
$image = $this->metaImage ?? SiteHelper::siteLogo();
$imageUrl = '';
if (!empty($image)) {
    $imageUrl = Yii::$app->urlManager->createAbsoluteUrl($image);
}

$url = Yii::$app->urlManager->createAbsoluteUrl(Url::current());

//Google Meta Tags

$this->registerMetaTag(['name' => 'title', 'content' => $title], 'title');
$this->registerMetaTag(['name' => 'description', 'content' => $description], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $keywords], 'keywords');

// Open Graph
$this->registerMetaTag(['property' => 'og:type', 'content' => "website"], 'ogType');
$this->registerMetaTag(['property' => 'og:url', 'content' => $url], 'ogUrl');
$this->registerMetaTag(['property' => 'og:title', 'content' => $title], 'ogTitle');
$this->registerMetaTag(['property' => 'og:description', 'content' => $description], 'ogDescription');
$this->registerMetaTag(['property' => 'og:image', 'content' => $imageUrl], 'ogImage');

// Twitter
$this->registerMetaTag(['property' => "twitter:card", 'content' => "summary_large_image"], "twitterCard");
$this->registerMetaTag(['property' => "twitter:url", 'content' => $url], 'twitterUrl');
$this->registerMetaTag(['property' => "twitter:title", 'content' => $title], 'twitterTitle');
$this->registerMetaTag(['property' => "twitter:description", 'content' => $description], 'twitterDescription');
$this->registerMetaTag(['property' => "twitter:image", 'content' => $imageUrl], 'twitterImage');

$isHomePage = Url::isHomePage();
$lang = Yii::$app->language;

?>

<?php $this->beginPage() ?>

    <!DOCTYPE html>

    <html lang="<?= Yii::$app->language ?>" class="h-100">

    <head>

        <meta charset="<?= Yii::$app->charset ?>">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php $this->registerCsrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>

        <?= SiteHelper::favicon() ?>

        <?php $this->head() ?>

    </head>

    <body>

    <div class="hidden-menu">

    </div>


    <?php $this->beginBody() ?>


    <?= $content ?>


    <?php $this->endBody() ?>

<!--    <script>-->
<!--        AOS.init();-->
<!--    </script>-->

    </body>
    </html>

<?php $this->endPage();
