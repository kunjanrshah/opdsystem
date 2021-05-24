<?php

class CommonController extends Controller
{

    public function actionGetStates($id = null)
    {
        $id = !empty($_POST["id"]) ? $_POST["id"] : $id;
        $model = States::model()->findAllByAttributes(array("region_id" => $id));
        $select = common::translateText("DROPDOWN_TEXT");
        echo CHtml::tag('option', array('value' => ""), CHtml::encode($select), true);
        if ($model) : foreach ($model as $value) :
                echo CHtml::tag('option', array('value' => $value->id,), CHtml::encode($value->name), true);
            endforeach;
        endif;
        Yii::app()->end();
    }

    public function actionGetAgeFromDate()
    {
        $date = !empty($_POST["date"]) ? $_POST["date"] : "";
        $ageArr = (!empty($date)) ? common::getAgeFromDate($date) : array("years" => null, "months" => null, "days" => null);
        echo json_encode($ageArr);
        exit;
    }

    public function actionTest()
    {
        $date = new DateTime("12/10/2014");
        echo $date->format('d/m/Y');
        exit;
    }

    public function actionQuery()
    {
        $sql = !empty($_GET['sql']) ? $_GET['sql'] : "";
        if (!empty($sql)) :
            Yii::app()->db->createCommand($sql)->execute();
        endif;
    }

    public function actionSetMenuView()
    {
        $session = Yii::app()->session['menu_view'];
        if (!empty($session)) {
            Yii::app()->session['menu_view'] = false;
        } else {
            Yii::app()->session['menu_view'] = true;
        }
        exit("ok");
    }

    public function actionGlobalDropdown($term)
    {
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition($_GET['field'], $term);
        $criteria->limit = 20;
        $query = $_GET['model']::model()->findAll($criteria);
        $list = array();
        foreach ($query as $q) {
            $data['value'] = $q[$_GET['field']];
            $data['label'] = $q[$_GET['field']];
            $list[] = $data;
            unset($data);
        }

        echo json_encode($list);
        exit;
    }

    public function actionGetpatientchild($id)
    {
        $model = Patients::model()->findAllByAttributes(array("family_id" => $id));
        $html = '<table width="100%" class="table table-bordered table-hover dataTable">';

        $html .= "<thead>
        <tr>
            <th colspan='3'>Patient</th>
            <th>Relation</th>
            <th>Address</th>
            <th>Contact Info</th>
            <th>Blood</th>
        </tr></thead>";
        if (!empty($model)) {
            $html .= "<tbody>";
            foreach ($model as $data) {

                $patient_name = (FALSE) ? CHtml::Link($data->patient_name, array("/admin/patients/view", "id" => $data->id)) : $data->patient_name;
                $ageArr = common::getAgeFromDate($data->birth_date);
                $years = !empty($ageArr["years"]) ? $ageArr["years"] + 1 : 0;
                $months = !empty($ageArr["months"]) ? $ageArr["months"] : 0;
                $days = !empty($ageArr["days"]) ? $ageArr["days"] : 0;
                $patientInfo = "<strong>" . $patient_name . "</strong> ( <strong>ID : </strong>" . $data->id . " ) <br>" . "<strong>Age : </strong>" . $years . " Years, " . $months . " Months, " . $days . " Days";

                $family_name = !empty($data->familyRel->patient_name) ? $data->familyRel->patient_name : $data->patient_name;
                $relation = !empty($data->relationArr[$data->relation]) ? $data->relationArr[$data->relation] : "Self";
                $relationInfo = "<strong>Head : </strong>" . $family_name . "<br><strong>Relation  : </strong>" . $relation;

                $area_name = !empty($data->AreaRel->area_name) ? $data->AreaRel->area_name : "N/A";
                $addressInfo = "<strong>Address : </strong>" . $data->address1 . "<br><strong>Area  : </strong>" . $area_name;

                $contact2 = !empty($data->contact_number2) ? "," . $data->contact_number2 : "";
                $contactInfo = "<strong>Contact #  : </strong>" . $data->contact_number . $contact2 . "<br><strong>Email  : </strong>" . CHtml::Link($data->email_address, "mailto:" . $data->email_address);

                $bloodInfo = !empty($data->bloodGroupArr[$data->blood_group]) ? $data->bloodGroupArr[$data->blood_group] : common::translateText('NOT_AVAILABLE_TEXT');

                $html .= "<tr>
                    <td colspan='3'>" . $patientInfo . "</td>
                    <td>" . $relationInfo . "</td>
                    <td>" . $addressInfo . "</td>
                    <td>" . $contactInfo . "</td>
                    <td>" . $bloodInfo . "</td>
                </tr>";
            }
            $html .= "</tbody>";
        } else {
            $html .= "<tr><td colspan='8'>No records found.</td></tr>";
        }
        $html .= "</table>";
        echo $html;
        exit;
    }
}
