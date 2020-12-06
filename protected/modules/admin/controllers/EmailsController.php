<?php

class EmailsController extends Controller {

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
        $model = new EmailTemplates("search");
        $this->render('index', array("model" => $model));
    }

    /* add email group */

    public function actionAdd() {

        $model = new EmailTemplates('add');
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-email");

        if (isset($_POST['EmailTemplates'])) {
            $model->attributes = $_POST['EmailTemplates'];
            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", common::translateText( "ADD_SUCCESS"));
                $this->redirect(array("/admin/emails"));
            }
        }
        $this->render('addEmail', array('model' => $model));
    }

    /* update email */

    public function actionUpdate($id) {
        $model = $this->loadModel($id,"EmailTemplates");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-email");
        if (isset($_POST['EmailTemplates'])) {
            $model->attributes = $_POST['EmailTemplates'];
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText( "UPDATE_SUCCESS"));
                $this->redirect(array("/admin/emails"));
            }
        }
        $this->render('updateEmail', array('model' => $model));
    }

    /* delete user group */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id,"EmailTemplates");
            $model->deleted = true;
            if ($model->update()) {
                echo common::getMessage("success", common::translateText( "DELETE_SUCCESS"));
            } else {
                echo common::getMessage("danger", common::translateText( "DELETE_FAIL"));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText( "400_ERROR"));
        }
    }

    /* view user profile*/

    public function actionLogs() {
        $model = new EmailLogs("search");
        $this->render('logs', array("model" => $model));
    }

}
