<?php

class DashboardController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array(
                'allow', // allow authenticated user to perform these actions
                'actions' => array("index", "add"),
                'users' => array('@'),
            ),
            array(
                'deny', // deny all other actions
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
		
        if ($this->isPatient){
            $this->render('index');
		}
        else{
			
            $this->render('index_doctor');
			
        }
    }

}
