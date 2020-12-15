<?php

class RMedicineController extends Controller {

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
        $model = new RMedicineMaster("search");
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {
        if (Yii::app()->request->isPostRequest) {
            $response = array();
            Yii::app()->clientscript->scriptMap['jquery.min.js'] = FALSE;
            Yii::app()->clientscript->scriptMap['jquery.js'] = FALSE;
            $JSON = !empty($_REQUEST["json"]) ? true : false;
            $model = new RMedicineMaster();
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-rmedicine");

            if (isset($_POST['RMedicineMaster'])) {
                $model->attributes = $_POST['RMedicineMaster'];
                if ($model->validate()) {
                    $model->save();
                    $response["success"] = true;
                    $response["message"] = common::getMessage("success", common::translateText("ADD_SUCCESS"));
                    $response["data"] = $this->getOptions($model->id);
                    Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                } else {
                    $response["success"] = false;
                    $response["message"] = common::getMessage("danger", common::translateText("ADD_FAIL"));
                    Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
                }
                echo CJSON::encode($response);
                exit;
            }
            $this->layout = false;
            $this->render('_form_rmedicine', array('model' => $model), false, FALSE);
        } else
            throw new CHttpException(400, common::translateText("400_ERROR"));
    }

    /* update user group */

    public function actionUpdate($id) {
        if (Yii::app()->request->isPostRequest) {
            $response = array();
            Yii::app()->clientscript->scriptMap['jquery.min.js'] = FALSE;
            Yii::app()->clientscript->scriptMap['jquery.js'] = FALSE;
            $JSON = !empty($_REQUEST["json"]) ? true : false;
            $model = $this->loadModel($id, "RMedicineMaster");
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-rmedicine");

            if (isset($_POST['RMedicineMaster'])) {
                $model->attributes = $_POST['RMedicineMaster'];
                if ($model->validate()) {
                    $model->update();
                    $response["success"] = true;
                    $response["message"] = common::getMessage("success", common::translateText("ADD_SUCCESS"));
                    $response["data"] = $this->getOptions($model->id);
                    Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                } else {
                    $response["success"] = false;
                    $response["message"] = common::getMessage("danger", common::translateText("ADD_FAIL"));
                    Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
                }
                echo CJSON::encode($response);
                exit;
            }
            $this->layout = false;
            $this->render('_form_rmedicine', array('model' => $model), false, FALSE);
        } else
            throw new CHttpException(400, common::translateText("400_ERROR"));
    }

    public function getOptions() {
        $selected_id = !empty($_GET['selected'])?$_GET['selected']:'';
        $selected_id = explode(",", $selected_id);
        $model = RMedicineMaster::model()->findAll();
        $option = null;
        if ($model): foreach ($model as $value):
                $selected = in_array($value->id, $selected_id) ? true : false;
                $option.= CHtml::tag('option', array('value' => $value->id, 'selected' => $selected), CHtml::encode($value->title), true);
            endforeach;
        endif;
        return $option;
    }

    /* delete user group */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id, "RMedicineMaster");
            $model->deleted = true;

            if ($model->update()) {
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
