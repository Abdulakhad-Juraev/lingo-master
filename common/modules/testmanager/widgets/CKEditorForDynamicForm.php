<?php

namespace common\modules\testmanager\widgets;

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Json;
use yii\web\View;

class CKEditorForDynamicForm extends CKEditor
{

    public $dynamicFormWidgetContainer = 'dynamicform_wrapper';

    public $dynamicFormWidgetBody = '.container-items';

    /**
     * @var string Hidden input for id.
     */
    public $hiddenInput = '.id-hidden-input';

    public function run()
    {
        parent::run();
        $this->registerExtraJs();
    }

    private function registerExtraJs()
    {
        if ($this->dynamicFormWidgetBody && $this->dynamicFormWidgetContainer) {

            $options = Json::encode($this->editorOptions);

            $js = "$('.$this->dynamicFormWidgetContainer').on('afterInsert', function(e, item){
                let lastTextarea = $('$this->dynamicFormWidgetBody textarea').last()
                let lastHiddenInput = $('$this->dynamicFormWidgetBody $this->hiddenInput').last()
                lastHiddenInput.val('')
                let textareaId = lastTextarea.attr('id');
                lastTextarea.val('')
                lastTextarea.focus()
                CKEDITOR.replace(textareaId,  $options);
            })";
            $this->view->registerJs($js, View::POS_END);
        }
    }
}