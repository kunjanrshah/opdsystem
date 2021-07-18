<?php

class TreatmentsController extends Controller {

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
                'actions' => array("gettreatments", "casepaper", "prescription"),
                'users' => array('@'),
            ),
            array(
                'deny', // deny all other actions
                'users' => array('*'),
            ),
        );
    }

    public function actionPrescription($id) {
        $model = $this->loadModel($id, "Treatments");

        if (isset($_GET["print"])) {

            Yii::import("ext.tcpdf.ETcPdf");

            $pdf = new ETcPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Prescription');
            $pdf->SetTitle('Prescription');
            $pdf->SetSubject('Prescription');
            $pdf->SetKeywords("Prescription");

            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            $pdf->SetFont('dejavusans', '', 10);

            $pdf->AddPage();
            $html = $this->renderPartial("_prescription_print", array("model" => $model), true, true);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('Prescription.pdf', 'D');
            exit;
        } else {
            $this->render("prescription", array("model" => $model));
        }
    }

    public function actionCasePaper($id) {
        $model = $this->loadModel($id, "Treatments");
        $this->render("case_paper", array("model" => $model));
    }

    /* View lising page */

    public function actionIndex() {
        $model = new Treatments("search");
        $model->unSetAttributes();
        if (isset($_GET['Treatments'])):
            $model->attributes = $_GET['Treatments'];
            $model->today = !empty($_GET['Treatments']['today']) ? true : false;
            if ($model->today):
                $this->layout = FALSE;
            endif;
        endif;
        // echo $model->start_date."==".$model->end_date;
        $this->render('application.modules.admin.views.treatments.index', array("model" => $model));
    }

    public function actionDetails($id = null) {
        Notifications::model()->setRead();
        $model = new Treatments("search");

        if (isset($_GET["Treatments"])):
            $model->attributes = $_GET["Treatments"];
        endif;
        $this->invalidAccess($model);
        $this->render('details', array("model" => $model, "id" => $id));
    }
    
    public function actionDetailsupdate($id = null) {
        Notifications::model()->setRead();
        $model = $this->loadModel($_GET["treatment_id"], "Treatments");

//        if (isset($_GET["Treatments"])):
//            $model->attributes = $_GET["Treatments"];
//        endif;
        $this->invalidAccess($model);
        $this->render('details', array("model" => $model, "id" => $id));
    }

    /* add record */

    public function actionAdd() {
        $model = new Treatments("add");
        if (isset($_GET["Treatments"])):
            $model->attributes = $_GET["Treatments"];
            $Treatments = Patients::model()->getPatientLastTreatment($model->patient_id);
            if (!empty($Treatments)):
                $model->patient_bmi = $Treatments->patient_bmi;
                $model->patient_height = $Treatments->patient_height;
                $model->patient_hip = $Treatments->patient_hip;
                $model->patient_pressure = $Treatments->patient_pressure;
                $model->patient_pulse = $Treatments->patient_pulse;
                $model->patient_resp = $Treatments->patient_resp;
                $model->patient_temp = $Treatments->patient_temp;
                $model->patient_waist = $Treatments->patient_waist;
            endif;
        endif;

        $this->invalidAccess($model);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-treatment");

        if (isset($_POST['Treatments'])) {
            $model->attributes = $_POST['Treatments'];
            $model->complains_id = !empty($_POST["Treatments"]["complains_id"]) ? $_POST["Treatments"]["complains_id"] : $model->complains_id;
            $model->diagnosis_id = !empty($_POST["Treatments"]["diagnosis_id"]) ? $_POST["Treatments"]["diagnosis_id"] : $model->diagnosis_id;
            $model->debit_amount = !empty($_POST["Treatments"]['debit_amount']) ? $_POST["Treatments"]['debit_amount'] : 0;
            $model->credit_amount = !empty($_POST["Treatments"]['credit_amount']) ? $_POST["Treatments"]['credit_amount'] : 0;
            $model->patient_bmi = !empty($_POST["Treatments"]["patient_bmi"]) ? $_POST["Treatments"]["patient_bmi"] : $model->patient_bmi;
            $model->patient_height = !empty($_POST["Treatments"]["patient_height"]) ? $_POST["Treatments"]["patient_height"] : $model->patient_height;
            $model->patient_hip = !empty($_POST["Treatments"]["patient_hip"]) ? $_POST["Treatments"]["patient_hip"] : $model->patient_hip;
            $model->patient_pressure = !empty($_POST["Treatments"]["patient_pressure"]) ? $_POST["Treatments"]["patient_pressure"] : $model->patient_pressure;
            $model->patient_pulse = !empty($_POST["Treatments"]["patient_pulse"]) ? $_POST["Treatments"]["patient_pulse"] : $model->patient_pulse;
            $model->patient_resp = !empty($_POST["Treatments"]["patient_resp"]) ? $_POST["Treatments"]["patient_resp"] : $model->patient_resp;
            $model->patient_temp = !empty($_POST["Treatments"]["patient_temp"]) ? $_POST["Treatments"]["patient_temp"] : $model->patient_temp;
            $model->patient_waist = !empty($_POST["Treatments"]["patient_waist"]) ? $_POST["Treatments"]["apatient_waist"] : $model->patient_waist;
            $model->patient_width = !empty($_POST["Treatments"]["patient_width"]) ? $_POST["Treatments"]["patient_width"] : $model->patient_width;
            $model->remarks = !empty($_POST["Treatments"]["remarks"]) ? $_POST["Treatments"]["remarks"] : '';


            if ($model->validate()) {
                if ($model->save()):
                    $Appointments = Appointments::model()->findByPk($model->appointment_id);
                    $Appointments->is_treatment_given = true;
                    $Appointments->update(false);
                endif;
                $this->saveTreatmentDetails($model);
                $this->saveTreatmentCharges($model);
                $this->saveNotifications($model);
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                if (isset($_POST['next'])) {
                    $this->redirect(array("/admin/dashboard/index"));
                } else if(isset($_POST['prescription'])) {
                    $this->redirect(array("/admin/treatments/prescription", "id" => $model->id));
                } else {
                    $this->redirect(array("/admin/treatments/casepaper", "id" => $model->id));
                }
            }
        }
        $this->render('addTreatment', array('model' => $model));
    }
    
    /* add record */

    public function actionUpdate() {
        $model = $this->loadModel($_GET["Treatments"]["id"], "Treatments");
        if (isset($_GET["Treatments"])):
            $model->attributes = $_GET["Treatments"];
            $Treatments = Patients::model()->getPatientLastTreatment($model->patient_id);
            if (!empty($Treatments)):
                $model->patient_bmi = $Treatments->patient_bmi;
                $model->patient_height = $Treatments->patient_height;
                $model->patient_hip = $Treatments->patient_hip;
                $model->patient_pressure = $Treatments->patient_pressure;
                $model->patient_pulse = $Treatments->patient_pulse;
                $model->patient_resp = $Treatments->patient_resp;
                $model->patient_temp = $Treatments->patient_temp;
                $model->patient_waist = $Treatments->patient_waist;
            endif;
        endif;

        $this->invalidAccess($model);
        $model->created_dt = common::getTimeStamp("", "Y-m-d H:i:s");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-treatment");

        if (isset($_POST['Treatments'])) {
            $model->attributes = $_POST['Treatments'];
            $model->complains_id = !empty($_POST["Treatments"]["complains_id"]) ? $_POST["Treatments"]["complains_id"] : $model->complains_id;
            $model->diagnosis_id = !empty($_POST["Treatments"]["diagnosis_id"]) ? $_POST["Treatments"]["diagnosis_id"] : $model->diagnosis_id;
            $model->debit_amount = !empty($_POST["Treatments"]['debit_amount']) ? $_POST["Treatments"]['debit_amount'] : 0;
            $model->credit_amount = !empty($_POST["Treatments"]['credit_amount']) ? $_POST["Treatments"]['credit_amount'] : 0;
            $model->patient_bmi = !empty($_POST["Treatments"]["patient_bmi"]) ? $_POST["Treatments"]["patient_bmi"] : $model->patient_bmi;
            $model->patient_height = !empty($_POST["Treatments"]["patient_height"]) ? $_POST["Treatments"]["patient_height"] : $model->patient_height;
            $model->patient_hip = !empty($_POST["Treatments"]["patient_hip"]) ? $_POST["Treatments"]["patient_hip"] : $model->patient_hip;
            $model->patient_pressure = !empty($_POST["Treatments"]["patient_pressure"]) ? $_POST["Treatments"]["patient_pressure"] : $model->patient_pressure;
            $model->patient_pulse = !empty($_POST["Treatments"]["patient_pulse"]) ? $_POST["Treatments"]["patient_pulse"] : $model->patient_pulse;
            $model->patient_resp = !empty($_POST["Treatments"]["patient_resp"]) ? $_POST["Treatments"]["patient_resp"] : $model->patient_resp;
            $model->patient_temp = !empty($_POST["Treatments"]["patient_temp"]) ? $_POST["Treatments"]["patient_temp"] : $model->patient_temp;
            $model->patient_waist = !empty($_POST["Treatments"]["patient_waist"]) ? $_POST["Treatments"]["apatient_waist"] : $model->patient_waist;
            $model->patient_width = !empty($_POST["Treatments"]["patient_width"]) ? $_POST["Treatments"]["patient_width"] : $model->patient_width;
            $model->remarks = !empty($_POST["Treatments"]["remarks"]) ? $_POST["Treatments"]["remarks"] : '';


            if ($model->validate()) {
                if ($model->save()):
                    $Appointments = Appointments::model()->findByPk($model->appointment_id);
                    $Appointments->is_treatment_given = true;
                    $Appointments->update(false);
                endif;
                $this->saveTreatmentDetails($model);
                $this->saveTreatmentCharges($model);
//                $this->saveNotifications($model);
                Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                if (isset($_POST['next'])) {
                    $this->redirect(array("/admin/dashboard/index"));
                } else if(isset($_POST['prescription'])) {
                    $this->redirect(array("/admin/treatments/prescription", "id" => $model->id));
                } else {
                    $this->redirect(array("/admin/treatments/casepaper", "id" => $model->id));
                }
            }
        }
        $this->render('addTreatment', array('model' => $model));
    }

    public function invalidAccess($model) {
        if (empty($model->patient_id) || empty($model->appointment_id)):
            Yii::app()->user->setFlash("danger", common::translateText("CAUTION_MSG"));
            $this->redirect(array("/admin/appointments"));
        endif;
    }

    public function actionGetTreatments() {
        if (Yii::app()->request->isAjaxRequest) {
            $diagnosis_id = !empty($_POST["Treatments"]["diagnosis_id"]) ? $_POST["Treatments"]["diagnosis_id"] : array();
            $complains_id = !empty($_POST["Treatments"]["complains_id"]) ? $_POST["Treatments"]["complains_id"] : array();
            $options = "";
            $advices = [];
            $treatments = array();
            if (!empty($diagnosis_id)):
				$criterias = new CDbCriteria();
				$List = implode(',', $diagnosis_id);
                if(!empty($List)):
                $criterias->condition = "id IN (" . $List . ")";
                $DiagnosisMaster = DiagnosisMaster::model()->findAll($criterias);
				
                //$DiagnosisMaster = DiagnosisMaster::model()->findByPk($diagnosis_id);
				foreach ($DiagnosisMaster as $value):
					$criteria = new CDbCriteria();
                    if(!empty($value->complains)):
					$criteria->condition = "id IN (" . implode(",", $value->complains) . ")";
                    if(!empty($value->description)) {
                        $advices[] = $value->description;
                    }
					$model = ComplainsMaster::model()->findAll($criteria);
					if ($model): foreach ($model as $value):
							$options.= CHtml::tag('option', array('value' => $value->id, "selected" => true), CHtml::encode($value->complain_title), true);
						endforeach;
					endif;
                endif;
				endforeach;
				
                $crit = new CDBCriteria();
                $crit->join = "LEFT JOIN `".MedicineMaster::tableName()."` AS MM ON MM.id = t.medicine_id";
                $crit->compare("diagnosis_id",$diagnosis_id);
                $crit->order = "MM.is_internal ASC";
                $DiagnosisTreatments = DiagnosisTreatments::model()->findAll($crit);

                if (!empty($DiagnosisTreatments)): $i = 0;
                    foreach ($DiagnosisTreatments as $value):
                        $treatments[$i]["medicine_id"] = $value->medicine_id;
                        $treatments[$i]["doseage_id"] = $value->doseage_id;
                        $treatments[$i]["is_internal"] = MedicineMaster::model()->findByPk($value->medicine_id)->is_internal;
                        $i++;
                    endforeach;
                endif;
            endif;
            endif;
            echo json_encode(array("options" => $options, "treatments" => $treatments, "advices"=> $advices));
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

    public function saveTreatmentDetails($model) {
        if (!empty($_POST["TreatmentDetails"])):
            $criteria = new CDbCriteria();
            $criteria->compare("treatment_id", $model->id);
            TreatmentDetails::model()->deleteAll($criteria);
            foreach ($_POST["TreatmentDetails"] as $value):
                if (!empty($value["medicine_id"]) && !empty($value["doseage_id"])):
                    $TreatmentDetails = new TreatmentDetails();
                    $TreatmentDetails->attributes = $value;
                    $TreatmentDetails->treatment_id = $model->id;
                    $TreatmentDetails->days = $value["days"];
                    //common::pr($TreatmentDetails->attributes);exit;
                    $TreatmentDetails->save(false);
                endif;
            endforeach;
        endif;
    }

    public function saveTreatmentCharges($model) {
        if (!empty($_POST["TreatmentCharges"])):
            $criteria = new CDbCriteria();
            $criteria->compare("treatment_id", $model->id);
            TreatmentCharges::model()->deleteAll($criteria);
            foreach ($_POST["TreatmentCharges"] as $value):
                if (!empty($value["charge_id"]) && !empty($value["amount"])):
                    $TreatmentCharges = new TreatmentCharges();
                    $TreatmentCharges->attributes = $value;
                    $TreatmentCharges->treatment_id = $model->id;
                    //common::pr($TreatmentCharges->attributes);exit;
                    $TreatmentCharges->save(false);
                endif;
            endforeach;
        endif;
    }

    public function saveNotifications($model) {
        $users = Users::model()->findAllByAttributes(array("user_group" => UsersGroup::COMPOUNDER));
        if (!empty($users)) {
            foreach ($users as $user) {
                $notification = new Notifications();
                $notification->user_id = $user->id;

                $Patient = Patients::model()->findByPk($model->patient_id);

                $family_name = !empty($Patient->familyRel->family_name) ? $Patient->familyRel->family_name : "N/A";
                $description = "Date Time : " . $model->created_dt . "<br />";
                $description .= "ID : " . $Patient->id . "<br />";
                $description .= "Name : <b>" . $Patient->patient_name . "</b><br />";
                $description .= "Head : " . $family_name;

                $notification->description = $description;
                $notification->link = "treatments/details/$model->id?Treatments[patient_id]=$model->patient_id&Treatments[appointment_id]=$model->appointment_id";
                $notification->save(FALSE);
            }
        }
    }

}