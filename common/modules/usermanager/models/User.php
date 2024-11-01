<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 06.07.2021, 15:07
 */

namespace common\modules\usermanager\models;

use Yii;

class User extends \common\models\User
{

    /**
     * Assigns roles to this user
     * @param string[] $roleNames List of role names to be assigned
     * @throws \Exception
     */
    public function assignNewRoles($roleNames)
    {
        foreach ($roleNames as $roleName) {
            if ($roleNames != 'admin') {
                $this->assignRole($roleName);
            }
        }
    }

    /**
     * Updates existing roles of the user
     * @param string[] $roleNames List of role names to be updated
     * @throws \Exception
     */
    public function updateRoles($roleNames): void
    {
        $auth = Yii::$app->authManager;
        $oldRoles = $auth->getRolesByUser($this->id);
        $oldRoleNames = array_keys($oldRoles);
        $diffRoles = array_values(array_diff($oldRoleNames, $roleNames));
        $newRoles = array_values(array_diff($roleNames, $oldRoleNames));
        if (!empty($diffRoles)) {
            $this->revokeUserRoles($diffRoles);
        }
        if (!empty($newRoles)) {
            $this->assignNewRoles($newRoles);
        }
    }

    /**
     * Revokes roles to this user
     * @param string[] $roleNames List of role names to be revoked
     * @throws \Exception
     */
    public function revokeUserRoles($roleNames)
    {
        foreach ($roleNames as $roleName) {
            if ($roleName != 'admin') {
                $this->revokeRole($roleName);
            }
        }
    }

    public function attributeHints()
    {
        return [
            'password' => Yii::t('app','Password-Hint'),
        ];
    }

}