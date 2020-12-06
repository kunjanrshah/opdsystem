<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to 'column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = "mainColumn";
    //public $layoutPath 	  = 'protected/modules/admin/views/layouts/';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    
    public $isDoctor,$isSuperAdmin,$isCompounder,$isPatient;

    public function init() 
    {
        $allowedPath = array("login","register");
        if (!in_array(Yii::app()->controller->id,$allowedPath)  && !Users::model()->isAdminLoggedIn()) {
            $this->redirect(Yii::app()->user->loginUrl);
        }
        if(!Yii::app()->user->isGuest){
            $this->isDoctor     = common::isDoctor();
            $this->isSuperAdmin = common::isSuperAdmin();
            $this->isCompounder = common::isCompounder();
            $this->isPatient = common::isPatient();
        }
    }

    protected function performAjaxValidation($model, $formId) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $formId) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function loadModel($id,$modelName) {
        $model = $modelName::model()->findByPk($id);
        if (!empty($model))
            return $model;
        else
            throw new CHttpException(404, common::translateText( "404_ERROR"));
    }
    protected function getNextInsertID($modelName){
       $criteria = new CDbCriteria();
       $criteria->select = "MAX(id) AS id";
       $count =  $modelName::model()->find($criteria)->id;
       return !empty($count)?$count+1:1;
    }
}
