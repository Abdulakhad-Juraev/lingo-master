<?php


/* @var $this View */
/* @var $roll array|AuthItem|ActiveRecord */

/* @var $items array|AuthItem[]|ActiveRecord[] */

use common\modules\auth\models\AuthItem;
use common\modules\auth\models\AuthItemChild;
use soft\helpers\Url;
use soft\widget\kartik\ActiveForm;
use yii\db\ActiveRecord;
use yii\web\View;
$this->title = Yii::t('app', 'Permission');
?>
<?php
$css = <<<CSS
ul {
  list-style: none;
}


CSS;
$this->registerCss($css);
?>
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Permission</h3>
        </div>
        <div class="box-body">
            <?php ActiveForm::begin(['action' => Url::to(['/auth-manager/roll/permission-create'])]) ?>
            <input type="hidden" name="roll-name" value="<?= $roll->name ?>">
            <div class="row">
                <?php foreach ($items as $item): ?>
                    <div class="col-md-4">
                        <ul>
                            <li>
                                <label for="<?=$item->name?>">
                                    <input type="checkbox" name="redskins" id="<?=$item->name?>"> <?= $item->name ?></label>
                                <ul>
                                    <?php
                                    $items_permission = AuthItem::getChildren($item->name);
                                    ?>
                                    <?php if ($items_permission): ?>
                                        <?php foreach ($items_permission as $item_perssmion): ?>
                                            <?php $items_child = AuthItemChild::find()
                                                ->andWhere(['child' => $item_perssmion->name,'parent'=>$roll->name])
                                                ->one() ?>
                                            <li>
                                                <input type="checkbox" name="items[]"
                                                       value="<?= $item_perssmion->name ?>"
                                                       id="<?= $item_perssmion->name ?>"
                                                    <?= $items_child ? 'checked' : '' ?>
                                                >
                                                <label for="<?= $item_perssmion->name ?>"> <?= $item_perssmion->name ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success" type="submit" style="float: right">Saqlash</button>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>

<?php
$js = <<<JS
$('input[type=checkbox]').change(function (e) {
  var checked = $(this).prop('checked');
  var isParent = !!$(this).closest('li').find(' > ul').length;
  if (isParent) {
    // if a parent level checkbox is changed, locate all children
    var children = $(this).closest('li').find('ul input[type=checkbox]');
    children.prop({
      checked
    }); // all children will have what parent has
  } else {
    // if a child checkbox is changed, locate parent and all children
    var parent = $(this).closest('ul').closest('li').find('>label input[type=checkbox]');
    var children = $(this).closest('ul').find('input[type=checkbox]');
    if (children.filter(':checked').length === 0) {
      // if all children are unchecked
      parent.prop({ checked: false, indeterminate: false });
    } else if (children.length === children.filter(':checked').length) {
      // if all children are checked
      parent.prop({ checked: true, indeterminate: false });
    } else {
      // if some of the children are checked
      parent.prop({ checked: true, indeterminate: true });
    }
  }
});
JS;
$this->registerJs($js);

?>