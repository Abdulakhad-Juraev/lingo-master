<?php

/*
 *  @author Shukurullo Odilov <shukurullo0321@gmail.com>
 *  @link telegram: https://t.me/yii2_dasturchi
 *  @date 13.05.2022, 14:54
 */

namespace api\behaviors;

use Yii;

/**
 * Language setter for API requests.
 * @package api\behaviors
 */
class ChangeLanguageBehavior extends \soft\i18n\ChangeLanguageBehavior
{

    /**
     * @return string
     */
    protected function getRequestLanguage()
    {
        return Yii::$app->request->headers->get('Accept-Language', Yii::$app->params['defaultLanguage']);
    }

}
