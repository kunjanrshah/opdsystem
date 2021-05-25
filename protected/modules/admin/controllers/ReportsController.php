<?php

class ReportsController extends Controller {

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

    public function actionIndex() {
        $model = new Treatments("search");
        if (isset($_GET["Treatments"])):
            $model->attributes = $_GET["Treatments"];
        endif;
        $model->start_date = !empty($_GET['Treatments']['start_date']) ? $_GET['Treatments']['start_date'] : (common::getDateTime("now", "01/m/Y"));
        $model->end_date = !empty($_GET['Treatments']['end_date']) ? $_GET['Treatments']['end_date'] : (common::getDateTime("now", "t/m/Y"));

        $criteria = new CDbCriteria();
        // $criteria->compare("t.treatment_id",$model->treatment_id);
        $criteria->compare("t.diagnosis_id", $model->diagnosis_id);
        $criteria->compare("t.patient_id", $model->patient_id);

        $start_date = common::getTimeStamp($model->start_date);
        $end_date = common::getTimeStamp($model->end_date);
		
        if (!empty($start_date) && !empty($end_date)) {
            $criteria->addCondition("t.created_dt >= '" . $start_date . "'", 'AND');
            $criteria->addCondition("t.created_dt <= '" . $end_date . "'", 'AND');
        } else {
            if (!empty($start_date)) {
                $criteria->addCondition("t.created_dt  = '" . $start_date . "'", 'AND');
            } else if (!empty($end_date)) {
                $criteria->addCondition("t.created_dt  = '" . $end_date . "'", 'AND');
            }
        }
		$criteria->order = "t.id DESC";
        $data = Treatments::model()->findAll($criteria);
        //common::pr($data);exit;
        $this->render('index', array("model" => $model, "data" => $data));
    }

    public function actionExport() {
        $model = new Treatments("search");
        if (isset($_GET["Treatments"])):
            $model->attributes = $_GET["Treatments"];
        endif;
        $model->start_date = !empty($_GET['Treatments']['start_date']) ? $_GET['Treatments']['start_date'] : (common::getDateTime("now", "01/m/Y"));
        $model->end_date = !empty($_GET['Treatments']['end_date']) ? $_GET['Treatments']['end_date'] : (common::getDateTime("now", "t/m/Y"));

        $criteria = new CDbCriteria();
        // $criteria->compare("t.treatment_id",$model->treatment_id);
        $criteria->compare("t.diagnosis_id", $model->diagnosis_id);
        $criteria->compare("t.patient_id", $model->patient_id);

        $start_date = common::getTimeStamp($model->start_date);
        $end_date = common::getTimeStamp($model->end_date);
        if (!empty($start_date) && !empty($end_date)) {
            $criteria->addCondition("t.created_dt >= '" . $start_date . "'", 'AND');
            $criteria->addCondition("t.created_dt <= '" . $end_date . "'", 'AND');
        } else {
            if (!empty($start_date)) {
                $criteria->addCondition("t.created_dt  = '" . $start_date . "'", 'AND');
            } else if (!empty($end_date)) {
                $criteria->addCondition("t.created_dt  = '" . $end_date . "'", 'AND');
            }
        }

        $teamp_data = Treatments::model()->findAll($criteria);
        $data = array();
        $grandTotal = 0;
        $grandDebit = 0;
        if (!empty($teamp_data)) {
            foreach ($teamp_data as $value) {
                $original_data = array();
                if (!empty($value->patientRel)) {
                    $original_data['Treatment Date Time'] = $value->created_dt;
                    $original_data['Patient'] = $value->patientRel->patient_name;
                    ;
                    $original_data['Diagnosis'] = $value->diagnosisRel->diagnosis_title;
                    $original_data['Charges'] = '';
                    $total = 0;
                    $debit = !empty($value->debit_amount) ? $value->debit_amount : 0;
                    if (!empty($value->treatmentChargesRel)) {
                        foreach ($value->treatmentChargesRel as $charges) {
                            $original_data['Charges'] .= (isset($original_data['Charges']) && $original_data['Charges'] != '') ? "," : '';
                            $original_data['Charges'] .= $charges->chargeRel->charge_title . " (" . $charges->amount . ")";
//                            $original_data['Charges'] .= " ";
                            $total +=$charges->amount;
                        }
                    } else {
                        $original_data['Charges'] .= common::translateText("NOT_AVAILABLE_TEXT");
                    }

                    $original_data['Credit'] = $total;
                    $grandTotal+=$total;
                    $grandDebit+=$debit;
                    $original_data['Debit'] = $debit;
                    $data[] = $original_data;
                } else {
                    //$data = array("No records found.");
                }
            }
            $data[] = array("Treatment Date Time" => "Total", "Patient" => "", "Diagnosis" => "", "Charges" => $grandTotal + $grandDebit, "Credit" => $grandTotal, "Debit" => $grandDebit);
        } else {
            $data[] = array("data" => "No records found.");
        }

        //common::pr($data);
        //echo "<pre>";
        //print_r($data);exit;
        //$this->render('index', array("model" => $model,"data"=>$data));
        // file name for download
        $fileName = "export_data" . date('Ymd') . ".xls";

        // headers for download
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

//        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
//        $flag = false;
//        foreach ($data as $row) {
//            if (!$flag) {
//                // display column names as first row
//                echo implode("\t", array_keys($row)) . "\n";
//                $flag = true;
//            }
//            // filter data
//            array_walk($row, array($this, 'filterData'));
//            echo implode("\t", array_values($row)) . "\n";
//        }
        $tableData = "<style> table, td {border:0.5pt solid black} table {border-collapse:collapse} th {background-color:#d2e8b8}</style><table style='border:0.5pt solid windowtext'>";
        $tableData .="<tr><th style='background-color:#d2e8b8'>Treatment Date Time</th><th style='background-color:#d2e8b8'>Patient</th><th style='background-color:#d2e8b8'>Diagnosis</th><th style='background-color:#d2e8b8'>Charges</th><th style='background-color:#d2e8b8'>Credit</th><th style='background-color:#d2e8b8'>Debit</th></tr>";
        $countRow = 0;
        foreach ($data as $row) {
            $tableData .= "<tr>";
            foreach ($row as $cell) {
                if (count($data) == $countRow + 1) {
                    $tableData .= "<td style='background-color:#d2e8b8;font-weight:bold'>" . $cell . "</td>";
                } else {
                    $tableData .= "<td>" . $cell . "</td>";
                }
            }
            $tableData .= "</tr>";
            $countRow++;
        }
        $tableData .= "</table>";
        echo $tableData;
//echo iconv('utf-8', 'cp1251', "$tableData");
        exit;
    }

    function filterData(&$str) {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"'))
            $str = '"' . str_replace('"', '""', $str) . '"';
    }

}
