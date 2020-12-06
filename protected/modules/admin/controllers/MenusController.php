<?php

class MenusController extends Controller {

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
        $model = new MenusMaster("search");
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {
        if (Yii::app()->request->isPostRequest) {
            $model = new MenusMaster();
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-menu");

            if (isset($_POST['MenusMaster'])) {
                $model->attributes = $_POST['MenusMaster'];
                if ($model->validate()) {

                    $model->save();
                    Yii::app()->user->setFlash("success", common::translateText( "ADD_SUCCESS"));
                } else {
                    Yii::app()->user->setFlash("danger", common::translateText( "ADD_FAIL"));
                }
                $this->redirect(array("/admin/menus"));
            }

            $outputJs = Yii::app()->request->isAjaxRequest;
            $this->renderPartial('_form_menu', array('model' => $model), false, $outputJs);
        } else
            throw new CHttpException(400, common::translateText( "400_ERROR"));
    }

    /* update user group */

    public function actionUpdate($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id, "MenusMaster");
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-menu");

            if (isset($_POST['MenusMaster'])) {
                $model->attributes = $_POST['MenusMaster'];
                if ($model->validate()) {

                    $model->update();
                    Yii::app()->user->setFlash("success", common::translateText( "UPDATE_SUCCESS"));
                } else {
                    Yii::app()->user->setFlash("danger", common::translateText( "UPDATE_FAIL"));
                }
                $this->redirect(array("/admin/menus"));
            }

            $outputJs = Yii::app()->request->isAjaxRequest;
            $this->renderPartial('_form_menu', array('model' => $model), false, $outputJs);
        } else
            throw new CHttpException(400, common::translateText( "400_ERROR"));
    }

    /* delete user group */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "MenusMaster");
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
}
