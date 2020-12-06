<?php

class NotificationsController extends Controller {

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
                'actions' => array("getlivenotification","clearall"),
                'users' => array('@'),
            ),
            array(
                'deny', // deny all other actions
				'actions' => array("clearall"),
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $model = new Notifications("search");
        $this->render('index', array("model" => $model));
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
                    $model = $this->loadModel($id, "Notifications");
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
	public function actionClearall($id = null){
		if(Yii::app()->request->isAjaxRequest){			
			$res = Notifications::model()->setClearall(Yii::app()->user->id);
			if($res == true){				
					echo common::getMessage("success", common::translateText("DELETE_SUCCESS"));
				} else {
					echo common::getMessage("danger", common::translateText("DELETE_FAIL"));
				}
				Yii::app()->end();
				
		} else {
            throw new CHttpException(400, common::translateText("400_ERROR"));
        }
	}
    public function actionGetlivenotification() {
        $result = array();
        $result["count"] = Notifications::model()->totalNotifications(Yii::app()->user->id);
        echo json_encode($result);
        exit;
    }

}
