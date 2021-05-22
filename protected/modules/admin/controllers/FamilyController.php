<?php

class FamilyController extends Controller {



    //         $update = false;
    //         if (!empty($idsArr)) : foreach ($idsArr as $id):
    //                 $model = $this->loadModel($id, "FamilyMaster");
    //                 $update = ($model->delete()) ? true : false;
    //             endforeach;
    //         endif;

    //         if ($update) {
    //             echo common::getMessage("success", common::translateText("DELETE_SUCCESS"));
    //         } else {
    //             echo common::getMessage("danger", common::translateText("DELETE_FAIL"));
    //         }
    //         Yii::app()->end();
    //     } else {
    //         throw new CHttpException(400, common::translateText("400_ERROR"));
    //     }
    // }

    // public function getOptions($selected_id = null) {
    //     $model = FamilyMaster::model()->findAll();
    //     $select = common::translateText("DROPDOWN_TEXT");
    //     $option = null;
    //     $option .= CHtml::tag('option', array('value' => ""), CHtml::encode($select), true);
    //     if ($model): foreach ($model as $value):
    //             $selected = ($value->id == $selected_id) ? true : false;
    //             $option .= CHtml::tag('option', array('value' => $value->id, 'selected' => $selected), CHtml::encode($value->family_name_with_contact), true);
    //         endforeach;
    //     endif;
    //     return $option;
    // }

    public function actionTree($id) {
        $model =  Patients::model()->findAllByAttributes(array('family_id'=> $id));
        $patient = Patients::model()->findByPk($id);
        $this->render('tree', array("model" => $model, "patient"=> $patient));
    }

}
