<?php

namespace soft\widget\bs4;

use Yii;
use soft\widget\button\Buttons;
use yii\base\Arrayable;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * Class DetailView
 */
class DetailView extends \yii\widgets\DetailView
{

    public $options = ['class' => 'table'];

    public $condensed = true;
    public $hover = true;
    public $bordered = true;
    public $striped = true;

    /**
     * @var string text before table
     */
    public $before = "&nbsp;";

    /**
     * @var string text after table
     */
    public $after;

    public $panel = [
        'header' => false,
    ];

    /**
     * @var bool whether to render panel body
     */
    public $initPanel;

    public $toolbar = [];

    /**
     * @var bool Whether register break-words css styles
     * @see registerBreakWordsStyles()
     */
    public $breakWords = true;

    public function init()
    {
        $this->normalizeAttributes();

        if ($this->condensed) {
            Html::addCssClass($this->options, 'table-sm');
        }
        if ($this->hover) {
            Html::addCssClass($this->options, 'table-hover');
        }
        if ($this->bordered) {
            Html::addCssClass($this->options, 'table-bordered');
        }
        if ($this->striped) {
            Html::addCssClass($this->options, 'table-striped');
        }

        if ($this->initPanel === null) {
            $this->initPanel = !Yii::$app->request->isAjax;
        }

        parent::init();
    }


    public function run()
    {

        $this->registerBreakWordsStyles();

        if (!$this->initPanel) {
            echo $this->before;
            echo parent::run();
            echo $this->after;
        } else {

            $this->panel = array_merge([
                'header' => false,
                'bodyOptions' => ['style' => 'padding:15px'],
            ], $this->panel);

            Card::begin($this->panel);
            echo $this->before . $this->renderToolbar();
            echo parent::run();
            echo $this->after;
            Card::end();
        }

    }

    /**
     * @return string
     * @throws \Exception
     */
    public function renderToolbar()
    {

        if ($this->toolbar === false) {
            return '';
        }
        if (!is_array($this->toolbar)) {
            $content = $this->toolbar;
        } else {
            $content = Buttons::widget([
                'template' => $this->toolbar['template'] ?? -1,
                'buttons' => $this->renderButtons(),
                'separator' => '',
            ]);
        }

        return Html::tag('div', $content, ['class' => 'float-right', 'style' => 'margin-bottom:10px']);
    }

    /**
     * @return array
     */
    private function renderButtons()
    {

        $defaultButtons = [

            'update' => [
                'url' => ['update', 'id' => $this->model->id],
                'cssClass' => "btn btn-outline-primary",
                'icon' => 'edit',
                'title' => "Tahrirlash",
            ],
            'delete' => [
                'url' => ['delete', 'id' => $this->model->id],
                'cssClass' => "btn btn-outline-danger",
                'icon' => 'trash-alt',
                'title' => "O'chirish",
                'options' => [
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]

            ]

        ];
        $buttons = $this->toolbar['buttons'] ?? [];
        return ArrayHelper::merge($defaultButtons, $buttons);

    }

    /**
     * @return array
     */
    private function defaultConfigs()
    {
        return [
            'created_at' => [
                'label' => Yii::t('app', 'Created At'),
                'format' => 'dateTimeUz',
            ],
            'updated_at' => [
                'label' => Yii::t('app', 'Updated At'),
                'format' => 'dateTimeUz',
            ],
            'image' => [
                'format' => ['image', ['width' => '100%']],
            ],
            'content' => [
                'format' => 'html',
            ],
        ];
    }

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    protected function normalizeAttributes()
    {

        if ($this->attributes === null) {
            if ($this->model instanceof Model) {
                $this->attributes = $this->model->attributes();
            } elseif (is_object($this->model)) {
                $this->attributes = $this->model instanceof Arrayable ? array_keys($this->model->toArray()) : array_keys(get_object_vars($this->model));
            } elseif (is_array($this->model)) {
                $this->attributes = array_keys($this->model);
            } else {
                throw new InvalidConfigException('The "model" property must be either an array or an object.');
            }
            sort($this->attributes);
        }

        $defaultConfigs = $this->defaultConfigs();

        foreach ($this->attributes as $i => $attribute) {

            if (is_string($attribute)) {
                if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $attribute, $matches)) {
                    throw new InvalidConfigException('The attribute must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
                }


                ############  Custom code here ###############

                $attribute = [];
                $attribute['attribute'] = $matches[1];
                if (isset($matches[3])) {
                    $attribute['format'] = $matches[3];
                }
                if (isset($matches[5])) {
                    $attribute['label'] = $matches[5];
                }

                ############  End Custom code  ###############

                /*   $attribute = [
                       'attribute' => $matches[1],
                       'format' => isset($matches[3]) ? $matches[3] : 'text',
                       'label' => isset($matches[5]) ? $matches[5] : null,
                   ];
                   */
            }

            if (!is_array($attribute)) {
                throw new InvalidConfigException('The attribute configuration must be an array.');
            }

            ############  Custom code here ###############
            /**
             * Merge attribute elements and default configs
             * @see DetailView::defaultConfigs()
             */

            if (isset($attribute['attribute']) && isset($defaultConfigs[$attribute['attribute']])) {
                $attribute = array_merge($defaultConfigs[$attribute['attribute']], $attribute);
            }

            if (!isset($attribute['label'])) {
                $attribute['label'] = null;
            }

            if (!isset($attribute['format'])) {
                $attribute['format'] = 'text';
            }

            ############  End Custom code  ###############

            if (isset($attribute['visible']) && !$attribute['visible']) {
                unset($this->attributes[$i]);
                continue;
            }

            if (!isset($attribute['format'])) {
                $attribute['format'] = 'text';
            }
            if (isset($attribute['attribute'])) {
                $attributeName = $attribute['attribute'];
                if (!isset($attribute['label'])) {
                    $attribute['label'] = $this->model instanceof Model ? $this->model->getAttributeLabel($attributeName) : Inflector::camel2words($attributeName, true);
                }
                if (!array_key_exists('value', $attribute)) {
                    $attribute['value'] = ArrayHelper::getValue($this->model, $attributeName);
                }
            } elseif (!isset($attribute['label']) || !array_key_exists('value', $attribute)) {
                throw new InvalidConfigException('The attribute configuration requires the "attribute" element to determine the value and display label.');
            }

            if ($attribute['value'] instanceof \Closure) {
                $attribute['value'] = call_user_func($attribute['value'], $this->model, $this);
            }

            $this->attributes[$i] = $attribute;
        }

    }

    public function registerBreakWordsStyles()
    {
        if ($this->breakWords) {

            $css = "
            #{$this->getId()}  td {
                word-break: break-word;
                white-space: normal;
                }
            ";

            $this->view->registerCss($css);

        }

    }


}
