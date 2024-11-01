<?php

namespace common\modules\auth\components;

use common\modules\auth\models\AuthAssignment;
use common\modules\auth\models\AuthItemChild;
use common\modules\auth\models\AuthItemThree;
use common\modules\usermanager\models\AuthItem;
use Yii;
use yii\helpers\ArrayHelper;

class PermissionHelper
{
    private static $permissionsAndRoles;

    static function per($name)
    {
        return Yii::$app->user->can($name);
    }

    public static function can($permissionName, $action = null)
    {
        if (is_array($permissionName)) {
            $permissionName = array_values($permissionName);
            if (empty($permissionName[0])) {
                return false;
            }
            $permissionName = $permissionName[0];
        }
        $arr = self::getRolesAndPermissionsByUser(Yii::$app->user->identity->id);
        if ($action) {
            return isset($arr[$permissionName]) && isset($arr[$action]);
        } else {
            return isset($arr[$permissionName]);
        }
    }

    public static function canAdmin($permissionName, $action = null): bool
    {

        $arr = self::getRolesAndPermissionsByUser(Yii::$app->user->identity->id);
        /** @var AuthAssignment $user_item */
        $user_item = AuthAssignment::find()->andWhere(['user_id' => user('id')])->one();
        // If $permissionName is an array, get the first element
        if (is_array($permissionName)) {
            $permissionName =$permissionName[$user_item->item_name];

        }
        // Check if the permission exists in the array
        if (isset($arr[$permissionName])) {
            // If an action is provided, check both permission and action
            if ($action) {
                return isset($arr[$permissionName]) && isset($arr[$action]);
            } else {
                // Otherwise, just check permission
                return true;
            }
        }
        return false; // Permission not found
    }

    /**
     * @param int|null $userId
     * @return array
     */
    public static function getRolesAndPermissionsByUser(int $userId = null): array
    {
        if (self::$permissionsAndRoles === null) {
            $authManager = Yii::$app->getAuthManager();
            $permissions = $authManager->getPermissionsByUser($userId);
            $roles = $authManager->getRolesByUser($userId);
            $userPermissionsAndRoles = ArrayHelper::merge($permissions, $roles);
            foreach ($roles as $roleName => $roleArray) {
                $userPermissionsAndRoles = ArrayHelper::merge($userPermissionsAndRoles, $authManager->getChildRoles($roleName));
            }
            self::$permissionsAndRoles = $userPermissionsAndRoles;
        }
        return self::$permissionsAndRoles;
    }
}