<?php

namespace frontend\widgets;

use soft\helpers\Html;
use yii\base\Widget;

class Breadcrumbs extends Widget
{

    public $homeLink = ['site/index'];

    public $links = [];

    public $options = ['class' => 'breadcrump'];

    public function run()
    {

        $content = $this->renderLinks();
        return Html::tag('div', $content, $this->options);

    }

    private function renderLinks()
    {
        $links[] = $this->renderLink(['label' => t('Home page'), 'url' => $this->homeLink]);
        foreach ($this->links as $link) {
            $links[] = $this->renderLink($link);
        }
        return implode('', $links);
    }

    private function renderLink($link)
    {

        $url = $link['url'];
        if ($url) {
            return Html::a($link['label'], $url);
        }
        return Html::tag('p', $link['label']);
    }

}
