<?php
exit("coming soon..");
class CertificationsController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() 
    {
        $privilegeArr = AccessRules::getAccessRules();        
        return array(
            array(
                'allow', // allow authenticated user to perform these actions
                'actions' =>$privilegeArr,
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
        
    }

}
