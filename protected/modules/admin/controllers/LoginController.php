<?php

class LoginController extends Controller {

    public $layout = "loginColumn";

    public function actionIndex() {

		$model = new AdminLoginForm;
        Yii::app()->user->returnUrl = Yii::app()->createUrl("admin/patients");

        if (Users::model()->isAdminLoggedIn()) {
            $this->redirect(Yii::app()->user->returnUrl);
        }

        // collect user input data
        if (isset($_POST['AdminLoginForm'])) {
            
            $model->attributes = $_POST['AdminLoginForm']; 
            $model->isPatient = !empty($_POST['AdminLoginForm']["isPatient"])?true:false;
            $this->performAjaxValidation($model, "form-login");
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('index', array('model' => $model));
    }

    /* Register */

    public function actionRegister() 
    {
        $this->layout = "loginColumnBig";
        $model = new Patients("add");
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model, "form-patient");

        $model->id = $this->getNextInsertID("Patients");
        $model->status = Patients::ACTIVE;
        $model->registration_date = common::getDateTime("now", Yii::app()->params->dateFormatPHP);
        $model->username = null;
        $model->user_group = UsersGroup::PATIENT;
        if (isset($_POST['Patients'])) {
            $model->unSetAttributes();
            $model->attributes = $_POST['Patients'];
            $model->reference_by = !empty($_POST['Patients']['reference_by']) ? $_POST['Patients']['reference_by'] : "";
            $model->birth_date = !empty($_POST['Patients']['birth_date']) ? $_POST['Patients']['birth_date'] : "";

            if ($model->validate()) 
            {
                $old_password = $model->password;
                $model->save();
                $model->profile_pic = $model->uploadProfilePicture($model);
                if (!empty($model->profile_pic)):
                    $model->update();
                endif;
                
                /**Login**/
                $AdminLoginForm = new AdminLoginForm();
                $AdminLoginForm->username = $model->username;
                $AdminLoginForm->password = $old_password;
                $AdminLoginForm->isPatient = true;  
                // validate user input and redirect to the previous page if valid
                
                if ($AdminLoginForm->validate() && $AdminLoginForm->login()){
                    Yii::app()->user->setFlash("success", common::translateText("ADD_SUCCESS"));
                    $this->redirect(Yii::app()->user->returnUrl);
                }else{
                    Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
                }
                /** Login **/
            }else{
                Yii::app()->user->setFlash("danger", common::translateText("ADD_FAIL"));
            }
        }
        $this->render('patient_register', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        unset($_SESSION["is_backen_login"]);
        $this->redirect(Yii::app()->user->loginUrl);
    }

}
