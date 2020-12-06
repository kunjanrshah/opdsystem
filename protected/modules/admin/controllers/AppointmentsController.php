<?php

class AppointmentsController extends Controller {

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
                'actions' => array("quick","Getlivenotification"),
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
        $model = new Appointments("search");
        $model->unSetAttributes();
        if (isset($_GET['Appointments'])):
            $model->attributes = $_GET['Appointments'];
            $model->start_date = !empty($_GET['Appointments']['start_date']) ? common::getTimeStamp($_GET['Appointments']['start_date']) : "";
            $model->end_date = !empty($_GET['Appointments']['end_date']) ? common::getTimeStamp($_GET['Appointments']['end_date']) : "";
            $model->today = !empty($_GET['Appointments']['today']) ? true : false;
//            $model->is_treatment_given = !empty($_GET['Appointments']['is_treatment_given']) ? $_GET['Appointments']['is_treatment_given'] : $model->is_treatment_given;
            $model->is_treatment_given = isset($_GET['Appointments']['is_treatment_given']) ? $_GET['Appointments']['is_treatment_given'] : '';
            if ($model->today):
                $this->layout = FALSE;
            endif;
        endif;
        // echo $model->start_date."==".$model->end_date;
        $this->render('application.modules.admin.views.appointments.index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {

        $model = new Appointments();
        $model->appointment_date = !empty($_POST["Appointments"]['appointment_date']) ? $_POST["Appointments"]['appointment_date'] : common::getDateTime("now", Yii::app()->params->dateFormatPHP);
        $model->patient_id = !empty($_REQUEST["Appointments"]["patient_id"]) ? $_REQUEST["Appointments"]["patient_id"] : "";
        $model->is_confirmed = true;
        // Uncomment the following line if AJAX validation is needed            
        $this->performAjaxValidation($model, "form-appointment");

        if (isset($_POST['Appointments'])) {
            $model->attributes = $_POST['Appointments'];
            $model->description = !empty($_REQUEST["Appointments"]["description"]) ? $_REQUEST["Appointments"]["description"] : "";
            $model->is_confirmed = !empty($_REQUEST["Appointments"]["is_confirmed"]) ? $_REQUEST["Appointments"]["is_confirmed"] : $model->is_confirmed;
            //common::pr($model->attributes);exit;

            if ($model->validate()) {
                $model->save();
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
            } else {
                Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
            }
            $this->redirect(array("/admin/dashboard"));
        }
        $this->render('_form_appointment', array('model' => $model));
    }

    public function actionQuick() {
        $model = new Appointments();
        $model->appointment_date = common::getDateTime("now", Yii::app()->params->dateFormatPHP);
        $model->patient_id = !empty($_REQUEST["Appointments"]["patient_id"]) ? $_REQUEST["Appointments"]["patient_id"] : "";
//        $model->is_confirmed = true; 
        $model->is_confirmed = 1; //set 1 Because Is Confirm Integer issue
        $model->appointment_time = common::getDateTime("now", "H:i:s"); //static
        //$model->getFixedAppointments($model->appointment_date);
        if ($model->validate()) {
            $model->save();
            $this->redirect(array("/admin/dashboard"));
            Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
        } else {
            $errors = null;
            foreach ($model->getErrors() as $error):
                $errors.=@$error[0] . "<br />";
            endforeach;
            Yii::app()->user->setFlash("danger", $errors);
            $this->redirect(array("/admin/patients"));
        }
    }

    /* update user group */

    public function actionUpdate($id) {
        $model = $this->loadModel($id, "Appointments");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-appointment");

        if (isset($_POST['Appointments'])) {
            $model->attributes = $_POST['Appointments'];
            $model->description = !empty($_REQUEST["Appointments"]["description"]) ? $_REQUEST["Appointments"]["description"] : "";
            if ($model->validate()) {
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
            } else {
                Yii::app()->user->setFlash("danger", common::translateText("UPDATE_FAIL"));
            }
            $this->redirect(array("/admin/dashboard"));
        }
        $this->render('_form_appointment', array('model' => $model));
    }

    /* Delete Record */

    public function actionDelete($id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            if (!empty($id)):
                $idsArr = array($id);
            else:
                $idsArr = !empty($_POST["idList"]) ? $_POST["idList"] : array();
            endif;

            $update = false;
            if (!empty($idsArr)) : foreach ($idsArr as $id):
                    $model = $this->loadModel($id, "Appointments");
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

    public function disableTimeRanges($appointment_date) {
        $array = array();
        $criteria = new CDbCriteria();
        $criteria->compare("FROM_UNIXTIME(t.appointment_date,'%d/%m/%Y')", $appointment_date);
        $criteria->order = "appointment_time ASC";
        $model = Appointments::model()->Confirmed()->findAll($criteria);
        if (!empty($model)): foreach ($model as $value):
                // if(!empty($value->appointment_time)):
                $array[] = $value->appointment_time;
                // endif;
            endforeach;
        endif;
        //echo common::pr($array);
        return $array;
    }
	
	public function actionGetlivenotification() {
		$result = array();
		$model = Appointments::model()->findAll("is_treatment_given = 0 AND t.deleted = 0");		
		$page = $_POST['page'];
		
		if(strpos($page, 'dashboard/index') !== false)
		$result['page'] = true;
		
        $result["count"] = count($model);
		
        echo json_encode($result);
        exit;
    }

}
