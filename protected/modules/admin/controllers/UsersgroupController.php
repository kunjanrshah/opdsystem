<?php

class UsersgroupController extends Controller {

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
        $model = new UsersGroup("search");
        $model->unSetAttributes();
        if (isset($_GET['UsersGroup'])):
            $model->attributes = $_GET['UsersGroup'];
        endif;
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {
        if (Yii::app()->request->isPostRequest) {
            $model = new UsersGroup();
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-user-group");

            if (isset($_POST['UsersGroup'])) {
                $model->attributes = $_POST['UsersGroup'];
                if ($model->validate()) {
                    $model->save();
                    Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                } else {
                    Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
                }
                $this->redirect(array("/admin/usersgroup"));
            }

            $outputJs = Yii::app()->request->isAjaxRequest;
            $this->renderPartial('_form_users_group', array('model' => $model), false, $outputJs);
        } else
            throw new CHttpException(400, common::translateText("400_ERROR"));
    }

    /* update user group */

    public function actionUpdate($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id, "UsersGroup");
            // Uncomment the following line if AJAX validation is needed
            $this->performAjaxValidation($model, "form-user-group");

            if (isset($_POST['UsersGroup'])) {
                $model->attributes = $_POST['UsersGroup'];
                if ($model->validate()) {
                    $model->update();
                    Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                } else {
                    Yii::app()->user->setFlash("danger", common::translateText("UPDATE_FAIL"));
                }
                $this->redirect(array("/admin/usersgroup"));
            }

            $outputJs = Yii::app()->request->isAjaxRequest;
            $this->renderPartial('_form_users_group', array('model' => $model), false, $outputJs);
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
                    $model = $this->loadModel($id, "UsersGroup");
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

    /* view user permissions */

    public function actionPermissions($id) {
        if ($id == UsersGroup::SUPER_ADMIN) {
            Yii::app()->user->setFlash("danger", common::translateText("CAUTION_MSG"));
            $this->redirect(array("/admin/usersgroup"));
        }
        $model = $this->loadModel($id, "UsersGroup");

        $criteria = new CDbCriteria();
        $criteria->condition = "deleted=:deleted AND t.parent_id!=:parent_id";
        $criteria->params = array(":deleted" => 0, ":parent_id" => 0);
        $criteria->order = "parent_id ASC, menu_title ASC";
        $modelMenu = MenusMaster::model()->findAll($criteria);
        $modelRights = GroupRights::model()->findAll("group_id=:group_id", array(":group_id" => $id));

        $pastPermissionArr = array();
        if (!empty($modelRights)):
            foreach ($modelRights as $value):
                $pastPermissionArr[] = $value->menu_id;
            endforeach;
        endif;

        $parentMenuArr = CHtml::ListData(MenusMaster::model()->getParentMenus(), 'id', 'menu_title');
        $permissionsArr = array();
        if (!empty($modelMenu)):
            foreach ($modelMenu as $value):
                $permissionsArr[$value->parent_id][$value->id] = $value->menu_title;
            endforeach;
        endif;

        if (Yii::app()->request->isPostRequest) {
            GroupRights::model()->deleteAll("group_id=:group_id", array(":group_id" => $id));
            if (!empty($_POST["GroupRights"])) :
                foreach ($_POST["GroupRights"] as $menu_id => $true):
                    $saveModel = new GroupRights();
                    $saveModel->menu_id = $menu_id;
                    $saveModel->group_id = $id;
                    $saveModel->save(false);
                endforeach;
                Yii::app()->user->setFlash("success", common::translateText("UPDATE_SUCCESS"));
                $this->redirect(array("/admin/usersgroup/permissions", "id" => $id));
            endif;
        }
        $this->render('permissions', array("model" => $model, "parentMenuArr" => $parentMenuArr, "permissionsArr" => $permissionsArr, "pastPermissionArr" => $pastPermissionArr));
    }

}
