<?php

use soft\widget\adminlte3\Menu;
use yii\web\View;

/* @var $this View */

$menuItems = [
    ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index'], 'icon' => 'home',],
    [
        'label' => Yii::t('app', 'University'),
        'icon' => 'university',
        'items' => [
            ['label' => Yii::t('app', 'Faculty'), 'url' => ['/university-manager/faculty'],],
        ]
    ],
];
//    [
//        'label' => t('TOEFL® ITP & IELTS'),
//        'icon' => 'edit',
//        'items' => [
//            ['label' => t('English exam'), 'url' => ['/english-exam'],'visible' => P::canAdmin($permissions, 'english-exam/index')],
//            ['label' => t('TOEFL result'), 'url' => ['/toefl-exam/toefl-result'],'visible' => P::canAdmin($permissions, 'toefl-result/index')],
//            ['label' => t('IELTS result'), 'url' => ['/ielts-exam/ielts-result'], 'visible' => P::canAdmin($permissions,'ielts-result/index')],
//            [
//                'label' => t('IELTS check result') . ($unCheckedResult > 0 ? '<span class="badge badge-warning right">' . $unCheckedResult . '</span>' : ''),
//                'url' => ['/ielts-exam/ielts-check-result'],
//                'visible' => P::canAdmin($permissions,'ielts-check-result/index'),
//                'encode' => false,
//            ],
//        ]
//    ],
//    ['label' => Yii::t('app', 'Tariff'), 'url' => ['/tariff-manager/tariff'], 'icon' => 'bookmark',],
//    ['label' => Yii::t('app', 'Subjects'), 'url' => ['/test-manager/subject/index'], 'icon' => 'book', 'visible' => P::canAdmin($permissions, 'subject/index')],
//    ['label' => Yii::t('app', 'Test'), 'url' => ['/test-manager/test/index'], 'icon' => 'book', 'visible' => P::canAdmin($permissions, 'test/index')],
//    ['label' => Yii::t('app', 'Test Result'), 'url' => ['/test-manager/test-result'], 'icon' => 'book', 'visible' => P::canAdmin($permissions, 'test-result/index')],
//    ['label' => Yii::t('app', 'Test Sale'), 'url' => ['/test-manager/test-enroll'], 'icon' => 'book', 'visible' =>
//        P::canAdmin($permissions, 'test-enroll/index')],
//    ['label' => Yii::t('app', 'Teachers'), 'url' => ['/usermanager/teacher'], 'icon' => 'users', 'visible' => P::canAdmin($permissions, 'teacher/index')],
//    ['label' => Yii::t('app', 'Users'), 'url' => ['/usermanager/user'], 'icon' => 'address-book', 'visible' => P::canAdmin($permissions, 'teacher/index')],
//    ['label' => Yii::t('app', 'Student'), 'url' => ['/usermanager/student'], 'icon' => 'graduation-cap', 'visible' => P::canAdmin($permissions, 'student/index')],
//    [
//        'label' => t('Finance'),
//        'icon' => 'coins',
//        'items' => [
//            ['label' => 'Chart', 'url' => ['/site/chart'], 'icon' => 'chart-bar', 'visible' => P::canAdmin($permissions, 'site/chart')],
//            ['label' => Yii::t('app', 'User tariff'), 'url' => ['/usermanager/user-tariff'], 'icon' => 'coins', 'visible' => P::canAdmin($permissions, 'user-payment/index')],
//            ['label' => Yii::t('app', 'User payments'), 'url' => ['/usermanager/user-payment'], 'icon' => 'coins', 'visible' => P::canAdmin($permissions, 'user-payment/index')],
//        ],
//    ],
//    [
//        'label' => t('Site sections'),
//        'icon' => 'bars',
//        'items' => [
//            ['label' => t('Test list'), 'url' => ['/test-list'], 'visible' => P::canAdmin($permissions, 'test-list/index')],
//            ['label' => t('Faqs'), 'url' => ['/faq'], 'visible' => P::canAdmin($permissions, 'faq/index')],
//            ['label' => t('About us'), 'url' => ['/company-info'], 'visible' => P::canAdmin($permissions, 'company-info/index')],
//        ]
//    ],
//    [
//        'label' => Yii::t('app', 'Settings'),
//        'icon' => 'cogs',
//        'items' => [
//            ['label' => Yii::t('app', 'System Users'), 'url' => ['/usermanager/system-user'], 'icon' => 'users', 'visible' => P::canAdmin($permissions, 'teacher/index')],
//            ['label' => Yii::t('app', 'Roles'), 'url' => ['/auth-manager/roll/index'], 'visible' => P::canAdmin($permissions, 'roll/index')],
//            ['label' => Yii::t('app', 'Permission'), 'url' => ['/auth-manager/permission/index'], 'visible' => P::canAdmin($permissions, 'permission/index')],
//            ['label' => Yii::t('app', 'Translations'), 'url' => ['/translation-manager'], 'visible' => P::canAdmin($permissions, 'translation-manager/index')],
//            ['label' => Yii::t('app', 'Users'), 'url' => ['/usermanager/user/index'], 'visible' => P::canAdmin($permissions, 'user/index')],
//            ['label' => Yii::t('app', 'Settings'), 'url' => ['/settings'], 'visible' => P::canAdmin($permissions, 'settings/index')],
//        ]
//    ],
//    [
//        'label' => t('Area settings'),
//        'icon' => 'globe',
//        'items' => [
//            ['label' => t('Regions'), 'url' => ['/region-manager/region/index'], 'icon' => 'map-pin,fas', 'visible' => P::canAdmin($permissions, 'region/index')],
//            ['label' => t('District'), 'url' => ['/region-manager/district/index'], 'icon' => 'map-pin,fas', 'visible' => P::canAdmin($permissions, 'district/index')],
//        ]
//    ],
//    ['label' => t('Reports'), 'url' => ['/site/report'], 'icon' => 'file', 'visible' => P::canAdmin($permissions, 'site/report')],
//];
?>
<!---->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= to(['/site/index']) ?>" class="brand-link">
        <img src="<?= Yii::$app->user->identity->photoUrl ?? '/template/images/avatar-1.png' ?>" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Lingo Master</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <?= Menu::widget([
                'items' => $menuItems,
            ]) ?>
        </nav>
    </div>
</aside>
