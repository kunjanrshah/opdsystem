<?php

class CompaniesController extends Controller {

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
        $model = new CompanyMaster("search");
        $model->unSetAttributes();
        if (isset($_GET['CompanyMaster'])):
            $model->attributes = $_GET['CompanyMaster'];
        endif;
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {
        if (Yii::app()->request->isPostRequest) {
            $response = array();
            Yii::app()->clientscript->scriptMap['jquery.min.js'] = FALSE;
            Yii::app()->clientscript->scriptMap['jquery.js'] = FALSE;
            $model = new CompanyMaster();
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-company");

            if (isset($_POST['CompanyMaster'])) {
                $model->attributes = $_POST['CompanyMaster'];
                if ($model->validate()) {

                    $model->save();
                    Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                } else {
                    Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
                }
                $this->redirect(array("/admin/Companies"));
            }

            $this->layout = false;
            $this->render('_form_company', array('model' => $model), false, FALSE);
        } else
            throw new CHttpException(400, common::translateText("400_ERROR"));
    }

    /* update user group */

    public function actionUpdate($id) {
        if (Yii::app()->request->isPostRequest) {
            $response = array();
            Yii::app()->clientscript->scriptMap['jquery.min.js'] = FALSE;
            Yii::app()->clientscript->scriptMap['jquery.js'] = FALSE;
            $model = $this->loadModel($id, "CompanyMaster");
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-company");

            if (isset($_POST['CompanyMaster'])) {
                $model->attributes = $_POST['CompanyMaster'];
                if ($model->validate()) {
                    $model->update();
                    Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                } else {
                    Yii::app()->user->setFlash("danger", common::translateText("UPDATE_FAIL"));
                }
                $this->redirect(array("/admin/Companies"));
            }

            $this->layout = false;
            $this->render('_form_company', array('model' => $model), false, FALSE);
        } else
            throw new CHttpException(400, common::translateText("400_ERROR"));
    }

    /* delete user group */

    public function actionDelete($id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($id)):
                $idsArr = array($id);
            else:
                $idsArr = !empty($_POST["idList"]) ? $_POST["idList"] : array();
            endif;

            $update = false;
            if (!empty($idsArr)) : foreach ($idsArr as $id):
                    $model = $this->loadModel($id, "CompanyMaster");
                    $model->deleted = true;
                    $update = ($model->update()) ? true : false;
                endforeach;
            endif;

            if ($update) {
                echo common::getMessage("success", common::translateText("DELETE_SUCCESS"));
            } else {
                echo common::getMessage("danger", common::translateText("DELETE_FAIL"));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

}
