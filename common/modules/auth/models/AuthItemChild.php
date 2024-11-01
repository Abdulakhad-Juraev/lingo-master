<?php

namespace common\modules\auth\models;

use soft\db\ActiveRecord;

/**
 * @property string|null $parent
 * @property string|null $child
 */

class AuthItemChild extends ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'string'],
        ];
    }


    //</editor-fold>
}