<?php
namespace backend\ext\User;

use yii\rbac\PhpManager;

class BPhpAuthManager extends PhpManager
{
    public $itemFile = "@backend/rbac/items.php";

    public $assignmentFile = '@backend/rbac/assignments.php';

    public $ruleFile = '@backend/rbac/rules.php';
}
