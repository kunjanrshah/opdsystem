<?php

class SettingsController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        $privilegeArr = AccessRules::getAccessRules();
        return array(
            array(
                'allow', // allow authenticated user to perform these actions
                'actions' => $privilegeArr,
                'users' => array('@'),
            ),
            array(
                'allow', // allow all user to perform these actions
                'actions' => array(""),
                'users' => array('@'),
            ),
            array(
                'deny', // deny all other actions
                'users' => array('*'),
            ),
        );
    }

    /* View lising page */

    public function actionIndex() {
        $navArr = array();
        if (common::checkActionAccess("area/index")):
            $navArr[common::getTitle("area/index")] = Yii::app()->createUrl("/admin/area/index");
        endif;
        if (common::checkActionAccess("charges/index")):
            $navArr[common::getTitle("charges/index")] = Yii::app()->createUrl("/admin/charges/index");
        endif;
        if (common::checkActionAccess("companies/index")):
            $navArr[common::getTitle("companies/index")] = Yii::app()->createUrl("/admin/companies/index");
        endif;
        if (common::checkActionAccess("complains/index")):
            $navArr[common::getTitle("complains/index")] = Yii::app()->createUrl("/admin/complains/index");
        endif;
        if (common::checkActionAccess("diagnosis/index")):
            $navArr[common::getTitle("diagnosis/index")] = Yii::app()->createUrl("/admin/diagnosis/index");
        endif;
        if (common::checkActionAccess("dosages/index")):
            $navArr[common::getTitle("dosages/index")] = Yii::app()->createUrl("/admin/dosages/index");
        endif;
        if (common::checkActionAccess("drugs/index")):
            $navArr[common::getTitle("drugs/index")] = Yii::app()->createUrl("/admin/drugs/index");
        endif;
        if (common::checkActionAccess("family/index")):
            $navArr[common::getTitle("family/index")] = Yii::app()->createUrl("/admin/family/index");
        endif;
        if (common::checkActionAccess("cases/index")):
            $navArr[common::getTitle("cases/index")] = Yii::app()->createUrl("/admin/cases/index");
        endif;
        if (common::checkActionAccess("allergies/index")):
            $navArr[common::getTitle("allergies/index")] = Yii::app()->createUrl("/admin/allergies/index");
        endif;
        if (common::checkActionAccess("medicinegroup/index")):
            $navArr[common::getTitle("medicinegroup/index")] = Yii::app()->createUrl("/admin/medicinegroup/index");
        endif;
        if (common::checkActionAccess("medicine/index")):
            $navArr[common::getTitle("medicine/index")] = Yii::app()->createUrl("/admin/medicine/index");
        endif;
        if (common::checkActionAccess("rmedicine/index")):
            $navArr[common::getTitle("rmedicine/index")] = Yii::app()->createUrl("/admin/rmedicine/index");
        endif;
        if (common::checkActionAccess("menus/index")):
            $navArr[common::getTitle("menus/index")] = Yii::app()->createUrl("/admin/menus/index");
        endif;
        if (common::checkActionAccess("references/index")):
            $navArr[common::getTitle("references/index")] = Yii::app()->createUrl("/admin/references/index");
        endif;
        if (common::checkActionAccess("usersgroup/index")):
            $navArr[common::getTitle("usersgroup/index")] = Yii::app()->createUrl("/admin/usersgroup/index");
        endif;
        if (common::checkActionAccess("vaccine/index")):
        //    $navArr[common::getTitle("vaccine/index")] = Yii::app()->createUrl("/admin/vaccine/index");
        endif;
        $this->render('index', array("navArr" => $navArr));
    }

}
