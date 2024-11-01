<?php


namespace common\modules\usermanager\models\query;

use soft\db\ActiveQuery;

class EnrollQuery extends ActiveQuery
{
    /**
     * @return EnrollQuery
     */
    public function expired()
    {
        $this->andWhere(['<', 'enroll.end_at', time()]);
        return $this;
    }

    /**
     * @return EnrollQuery
     */
    public function nonExpired()
    {
        $this->andWhere(['>', 'enroll.end_at', time()]);
        return $this;
    }

    /**
     * Bepul a'zoliklarni filtrlash
     * @return $this
     */
    public function free()
    {
        $this->andWhere(['<', 'enroll.sold_price', 1]);
        return $this;
    }

    /**
     * Pullik a'zoliklarni filtrlash
     * @return $this
     */
    public function paid()
    {
        $this->andWhere(['>', 'enroll.sold_price', 0]);
        return $this;
    }


    /**
     * @return $this
     */
    public function started()
    {
        $this->andWhere(['<=', 'enroll.created_at', time()]);
        return $this;
    }
}