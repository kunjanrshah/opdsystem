<?php

class PatientsController extends Controller {

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
                'actions' => array("patientdropdown","patientonlynamedropdown","familyheaddropdown"),
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
        $model = new Patients("search");
        $model->unSetAttributes();
        if (isset($_GET['Patients'])):
            $model->attributes = $_GET['Patients'];
        endif;
        $this->render('index', array("model" => $model));
    }

    /* add record */

    public function actionAdd() {
        $model = new Patients("add");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-patient");

        $model->id = $this->getNextInsertID("Patients");
        $model->status = Patients::ACTIVE;
        $model->registration_date = common::getDateTime("now", Yii::app()->params->dateFormatPHP);
        $model->username = common::getTimeStamp("", "Y-m-d H:i:s");
        $model->password = $model->repeat_password = "admin";
        $model->user_group = UsersGroup::PATIENT;
        if (isset($_POST['Patients'])) {
            $model->unSetAttributes();
            $model->attributes = $_POST['Patients'];
            $model->reference_by = !empty($_POST['Patients']['reference_by']) ? $_POST['Patients']['reference_by'] : "";
            $model->birth_date = !empty($_POST['Patients']['birth_date']) ? $_POST['Patients']['birth_date'] : "";
            $model->contact_number2 = !empty($_POST['Patients']['contact_number2']) ? $_POST['Patients']['contact_number2'] : $model->contact_number2;
            if ($model->validate()) {
                $model->save();
                $model->profile_pic = $model->uploadProfilePicture($model);
                if (!empty($model->profile_pic)):
                    $model->update();
                endif;
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                $this->redirect(array("/admin/Patients"));
            }
        }
        $this->render('addPatient', array('model' => $model));
    }

    /* update record */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Patients");
        $model->scenario = "update";
        $old_profile_pic = $model->profile_pic;
        $yearsArr = common::getAgeFromDate($model->birth_date);
        $model->patient_age_years = $yearsArr["years"];
        $model->patient_age_months = $yearsArr["months"];
        $model->patient_age_days = $yearsArr["days"];

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-patient");
        if (isset($_POST['Patients'])) {
            $model->attributes = $_POST['Patients'];
            $model->reference_by = !empty($_POST['Patients']['reference_by']) ? $_POST['Patients']['reference_by'] : "";
            $model->birth_date = !empty($_POST['Patients']['birth_date']) ? $_POST['Patients']['birth_date'] : $model->birth_date;
            $model->contact_number2 = !empty($_POST['Patients']['contact_number2']) ? $_POST['Patients']['contact_number2'] : $model->contact_number2;
            if ($model->validate()) {
                $model->profile_pic = $model->uploadProfilePicture($model);

                $model->profile_pic = !empty($model->profile_pic) ? $model->profile_pic : $old_profile_pic;

                $model->update();

                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/admin/Patients"));
            }
        }
        $this->render('updatePatient', array('model' => $model));
    }

    /* view patient */

    public function actionView($id) {
//		echo "<pre>123";exit;
        $model = $this->loadModel($id, "Patients");
        $yearsArr = common::getAgeFromDate($model->birth_date);
        $model->patient_age_years = $yearsArr["years"];
        $model->patient_age_months = $yearsArr["months"];
        $model->patient_age_days = $yearsArr["days"];

        $this->render('viewPatient', array('model' => $model));
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
                    $model = $this->loadModel($id, "Patients");
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

    public function actionPatientdropdown($term) {
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition("CONCAT( id,  ' - ', patient_name,  ' - ', contact_number )", $term);
        $criteria->limit = 20;
        //$criteria->params = array(':patient_name' => "$term");
        $query = Patients::model()->findAll($criteria);
        $list = array();
        foreach ($query as $q) {
            $data['value'] = $q['id'];
            $data['label'] = $q['patient_name_with_id'];

            $list[] = $data;
            unset($data);
        }

        echo json_encode($list);
        exit;
    }
    public function actionPatientonlynamedropdown($term) {
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition("patient_name", $term);
        $criteria->limit = 20;
        //$criteria->params = array(':patient_name' => "$term");
        $query = Patients::model()->findAll($criteria);
        $list = array();
        foreach ($query as $q) {
            $data['value'] = $q['id'];
            $data['label'] = $q['patient_name'];

            $list[] = $data;
            unset($data);
        }

        echo json_encode($list);
        exit;
    }

    public function actionFamilyheaddropdown($term) {
        $criteria = new CDbCriteria();
//    $criteria->condition = 'family_id=0';
        $criteria->addSearchCondition("CONCAT( id,  ' - ', patient_name,  ' - ', contact_number )", $term);
        $criteria->limit = 20;
        //$criteria->params = array(':patient_name' => "$term");
        $query = Patients::model()->findAll($criteria);
        $list = array();
        foreach ($query as $q) {
            $data['value'] = $q['id'];
            $data['label'] = $q['patient_name_with_id'];

            $list[] = $data;
            unset($data);
        }

        echo json_encode($list);
        exit;
    }

}
