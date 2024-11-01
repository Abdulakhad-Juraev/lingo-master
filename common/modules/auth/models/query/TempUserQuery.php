<?php

namespace common\modules\auth\models\query;

/**
 * This is the ActiveQuery class for [[\common\modules\auth\models\TempUser]].
 *
 * @see \common\modules\auth\models\TempUser
 */
class TempUserQuery extends \soft\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return \common\modules\auth\models\TempUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\auth\models\TempUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
