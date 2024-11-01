<?php

namespace common\modules\auth\models;

use soft\db\ActiveRecord;

class AuthAssignment extends ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name'], 'string'],
            [['user_id'], 'integer'],
        ];
    }
}