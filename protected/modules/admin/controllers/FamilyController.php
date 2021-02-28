<?php

class FamilyController extends Controller {

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
        $model = new FamilyMaster("search");
        $model->unSetAttributes();
        if (isset($_GET['FamilyMaster'])):
            $model->attributes = $_GET['FamilyMaster'];
        endif;
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {
        if (Yii::app()->request->isPostRequest) {

            $model = new FamilyMaster();
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-family");

            if (isset($_POST['FamilyMaster'])) {
                $model->attributes = $_POST['FamilyMaster'];
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
                $this->redirect(array("/admin/family"));
            }
            $outputJs = Yii::app()->request->isAjaxRequest;
            $this->renderPartial('_form_family', array('model' => $model), false, $outputJs);
        } else
            throw new CHttpException(400, common::translateText("400_ERROR"));
    }

    /* update user group */

    public function actionUpdate($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id, "FamilyMaster");
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-family");

            if (isset($_POST['FamilyMaster'])) {
                $model->attributes = $_POST['FamilyMaster'];
                if ($model->validate()) {
                    $model->update();
                    $response["success"] = true;
                    $response["message"] = common::getMessage("success", common::translateText("UPDATE_SUCCESS"));
                    $response["data"] = $this->getOptions($model->id);
                    Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                } else {
                    $response["success"] = false;
                    $response["message"] = common::getMessage("danger", common::translateText("UPDATE_FAIL"));
                    Yii::app()->user->setFlash("danger", common::translateText("UPDATE_FAIL"));
                }
                $this->redirect(array("/admin/family"));
            }
            $outputJs = Yii::app()->request->isAjaxRequest;
            $this->renderPartial('_form_family', array('model' => $model), false, $outputJs);
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
                    $model = $this->loadModel($id, "FamilyMaster");
                    $update = ($model->delete()) ? true : false;
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

    public function getOptions($selected_id = null) {
        $model = FamilyMaster::model()->findAll();
        $select = common::translateText("DROPDOWN_TEXT");
        $option = null;
        $option .= CHtml::tag('option', array('value' => ""), CHtml::encode($select), true);
        if ($model): foreach ($model as $value):
                $selected = ($value->id == $selected_id) ? true : false;
                $option .= CHtml::tag('option', array('value' => $value->id, 'selected' => $selected), CHtml::encode($value->family_name_with_contact), true);
            endforeach;
        endif;
        return $option;
    }

}
