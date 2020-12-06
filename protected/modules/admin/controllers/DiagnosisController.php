<?php

class DiagnosisController extends Controller {

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
        $model = new DiagnosisMaster("search");
        $this->render('index', array("model" => $model));
    }

    /* add record */

    public function actionAdd() {

        $model = new DiagnosisMaster();
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-diagnosis");

        if (isset($_POST['DiagnosisMaster'])) {
            $model->attributes = $_POST['DiagnosisMaster'];
            if ($model->validate()) {
                $model->save();
                if (!empty($_POST["DiagnosisTreatments"])):
                    foreach ($_POST["DiagnosisTreatments"] as $value):
                        if (!empty($value["medicine_id"]) && !empty($value["doseage_id"])):
                            $DiagnosisTreatments = new DiagnosisTreatments();
                            $DiagnosisTreatments->attributes = $value;
                            $DiagnosisTreatments->diagnosis_id = $model->id;
                            $DiagnosisTreatments->save(false);
                        endif;
                    endforeach;
                endif;
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
            } else {
                Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
            }
            $this->redirect(array("/admin/diagnosis"));
        }
        $this->render('addDiagnosis', array('model' => $model));
    }

    /* update record */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "DiagnosisMaster");
        //$model = DiagnosisMaster::model()->with("DiagnosisTreatments")->findByPk($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-diagnosis");

        if (isset($_POST['DiagnosisMaster'])) {
            $model->attributes = $_POST['DiagnosisMaster'];
            if ($model->validate()) {
                $model->update();
                if (!empty($_POST["DiagnosisTreatments"])):
                    $criteria = new CDbCriteria();
                    $criteria->compare("diagnosis_id", $id);
                    DiagnosisTreatments::model()->deleteAll($criteria);
                    foreach ($_POST["DiagnosisTreatments"] as $value):
                        if (!empty($value["medicine_id"]) && !empty($value["doseage_id"])):
                            $DiagnosisTreatments = new DiagnosisTreatments();
                            $DiagnosisTreatments->attributes = $value;
                            $DiagnosisTreatments->diagnosis_id = $id;
                            $DiagnosisTreatments->save(false);
                        endif;
                    endforeach;
                endif;

                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
            } else {
                Yii::app()->user->setFlash("danger", common::translateText("UPDATE_FAIL"));
            }
            $this->redirect(array("/admin/Diagnosis"));
        }
        $this->render('updateDiagnosis', array('model' => $model));
    }

    /* delete record */

    public function actionDelete($id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($id)):
                $idsArr = array($id);
            else:
                $idsArr = !empty($_POST["idList"]) ? $_POST["idList"] : array();
            endif;

            $update = false;
            if (!empty($idsArr)) : foreach ($idsArr as $id):
                    $model = $this->loadModel($id, "DiagnosisMaster");
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

}
