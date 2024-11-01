<?php

namespace common\modules\usermanager\models\query;

use soft\db\ActiveQuery;

class UserTariffQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function expired()
    {
        $this->andWhere(['<', 'expired_at', time()]);
        return $this;
    }

    /**
     * @return $this
     */
    public function nonExpired()
    {
        $this->andWhere(['>=', 'expired_at', time()]);
        return $this;
    }

    /**
     * @return $this
     */
    public function started()
    {
        $this->andWhere(['<=', 'started_at', time()]);
        return $this;
    }
}