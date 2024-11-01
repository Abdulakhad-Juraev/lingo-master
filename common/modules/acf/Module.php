<?php

namespace common\modules\acf;

use soft\helpers\SiteHelper;
use Yii;

/**
 * acf module definition class
 */
class Module extends \yii\base\Module
{

    /**
     * Languages in terms of name-value pairs.
     * Such as:
     * ```php
     * [
     *      'en' => 'English',
     *      'ru' => 'Russian',
     *      'uz' => 'Uzbek',
     * ]
     * ```
     * As well you can use callback function.
     * Such as:
     * ```php
     * function () {
     *   return ...;
     * }
     * ```
     * @var array|callable
     */
    public $languages = [];

    public $defaultRoute = 'field/index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\acf\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $this->languages = SiteHelper::languages();
        // custom initialization code goes here
    }
}
