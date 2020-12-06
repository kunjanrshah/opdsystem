<?php

class UsersController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() 
    {
        $privilegeArr = AccessRules::getAccessRules();        
        return array(
            array(
                'allow', // allow authenticated user to perform these actions
                'actions' =>$privilegeArr,
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
        $model = new Users("search");
        $this->render('index', array("model" => $model));
    }

    /* add user group */

    public function actionAdd() {

        $model = new Users('add');
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-user");

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->save();
                $model->profile_pic = $model->uploadProfilePicture($model);
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText( "ADD_SUCCESS"));
                $this->redirect(array("/admin/users"));
            }
        }
        $this->render('addUser', array('model' => $model));
    }

    /* update user group */

    public function actionUpdate($id) {
        $model = $this->loadModel($id,"Users");
        $old_profile_pic = $model->profile_pic;
        $old_password = $model->password;
        $old_salt = $model->salt;
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-user");
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                if($model->password != ''){
                    $model->salt = uniqid('', true);
                   $model->password =md5($model->salt . $model->password);                   
                }else{
                   $model->password = $old_password; 
                   $model->salt = $old_salt;
                }
                $model->profile_pic = $model->uploadProfilePicture($model);
                $model->profile_pic = !empty($model->profile_pic) ? $model->profile_pic : $old_profile_pic;
                $model->update();
                Yii::app()->user->setFlash("success", common::translateText( "UPDATE_SUCCESS"));
                $this->redirect(array("/admin/users"));
            }
        }
        $this->render('updateUser', array('model' => $model));
    }

    /* delete user group */

    public function actionDelete($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id,"Users");
            $model->deleted = true;
            if ($model->update()) {
                echo common::getMessage("success", common::translateText( "DELETE_SUCCESS"));
            } else {
                echo common::getMessage("danger", common::translateText( "DELETE_FAIL"));
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, common::translateText( "400_ERROR"));
        }
    }

    /* view user profile*/

    public function actionProfile() {
        $this->render("profile");
    }
}
