<?php
namespace backend\ext\User;

use Yii;
use yii\web\User;

class BWebUser extends User
{
    private $permissionsAlreadyApplied = false;

//    private $fake;
//    public function init()
//    {
//        $this->fake = time();
//        parent::init();
//    }


    public function getIdentity($autoRenew = true)
    {
        $parentIdentity = parent::getIdentity($autoRenew);

        if (
            !is_null($parentIdentity)
            && $this->permissionsAlreadyApplied == false
        ) {
            $this->permissionsAlreadyApplied = true;
            $authManager = Yii::$app->authManager;

            $roleInt = BUserRbac::ROLE_OPER;
            //$roleInt = UserRbac::ROLE_ADMIN;
            //$roleInt = UserRbac::ROLE_ADMIN_SUPER;
            $role = $authManager->createRole($roleInt);
            $authManager->assign($role, $parentIdentity->getId());
        }

        return $parentIdentity;
    }

}
