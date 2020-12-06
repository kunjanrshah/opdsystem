<?php
class AccessRules
{
    public static function getAccessRules(){
        $controller = Yii::app()->controller->id;
        $action     = Yii::app()->controller->action->id; 
        $pageUrl    = $controller."/".$action;
        return (common::checkActionAccess($pageUrl))?array($action):array("");
    } 
}