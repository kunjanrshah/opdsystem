<?php

class CommonController extends Controller {

    public function actionGetStates($id = null) {
        $id = !empty($_POST["id"]) ? $_POST["id"] : $id;
        $model = States::model()->findAllByAttributes(array("region_id" => $id));
        $select = common::translateText("DROPDOWN_TEXT");
        echo CHtml::tag('option', array('value' => ""), CHtml::encode($select), true);
        if ($model): foreach ($model as $value):
                echo CHtml::tag('option', array('value' => $value->id,), CHtml::encode($value->name), true);
            endforeach;
        endif;
        Yii::app()->end();
    }

    public function actionGetAgeFromDate() {
        $date = !empty($_POST["date"]) ? $_POST["date"] : "";
        $ageArr = (!empty($date)) ? common::getAgeFromDate($date) : array("years" => null, "months" => null, "days" => null);
        echo json_encode($ageArr);
        exit;
    }

    public function actionTest() {
        $date = new DateTime("12/10/2014");
        echo $date->format('d/m/Y');
        exit;
    }

    public function actionGetPatient() {
        $id = !empty($_POST['Patients']['family_id']) ? $_POST['Patients']['family_id'] : 0;
        $array = array();
        if (!empty($id)):
            $model = Patients::model()->findByPk($id);
            if (!empty($model)):
                $array = $model->attributes;
            endif;
        endif;
        exit(json_encode($array));
    }

    public function actionQuery() {
        $sql = !empty($_GET['sql']) ? $_GET['sql'] : "";
        if (!empty($sql)):
            Yii::app()->db->createCommand($sql)->execute();
        endif;
    }

    public function actionSetMenuView() {
        $session = Yii::app()->session['menu_view'];
        if (!empty($session)) {
            Yii::app()->session['menu_view'] = false;
        } else {
            Yii::app()->session['menu_view'] = true;
        }
        exit("ok");
    }

    public function actionNotify($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = Notifications::model()->findAllByAttributes(array("user_id" => $id, "is_notify" => false));
            $response = array();
            $i = 0;
            if (!empty($model)) : foreach ($model as $value):
                    $response[$i]["title"] = "";
                    $response[$i]["text"] = CHtml::Link($value->description, array("admin/" . $value->link));
                    $i++;
                endforeach;
                Notifications::model()->updateAll(array('is_notify' => true), 'user_id=:user_id', array(':user_id' => $id));
            endif;

            echo json_encode($response);
            exit;
        } else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
    }

    public function actionGetMedicines($id = null) {
        $id = !empty($_POST["id"]) ? $_POST["id"] : $id;
        $model = MedicineMaster::model()->findAllByAttributes(array("group_id" => $id));
        $select = common::translateText("DROPDOWN_TEXT");
        echo CHtml::tag('option', array('value' => ""), CHtml::encode($select), true);
        if ($model): foreach ($model as $value):
                echo CHtml::tag('option', array('value' => $value->id,), CHtml::encode($value->medicine_name), true);
            endforeach;
        endif;
        Yii::app()->end();
    }

}
