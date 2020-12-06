<?php

class LeftMenu extends CWidget {

    public function run() { 
        $menusArr = $this->getLeftMenu();
        $this->render('_left_menu',array("menusArr"=>$menusArr));
    }
    public function getLeftMenu()
    {            
        $controller = Yii::app()->controller->id;
        $action = Yii::app()->controller->action->id;
        $currentUrl = $controller."/".$action;
        
        $permissionArr = array_keys(Yii::app()->user->_permissions); 
        $condition = !empty($permissionArr)? " AND childRel.id IN (".implode(",", $permissionArr).")":" AND childRel.id IN (0) ";
        $condition = (common::isSuperAdmin())?" ":$condition;
        
        $criteria = new CDbCriteria();
        $criteria->condition = "t.parent_id=:parent_id AND t.show_in_menu=:show_in_menu $condition ";
        $criteria->params = array(":parent_id" => 0,":show_in_menu"=>1);
        $criteria->order = "t.page_sort ASC";
        $model = MenusMaster::model()->with("childRel")->findAll( $criteria );
        
        $menusArr = array();
        
        if(!empty($model)): foreach ($model as $value):
            $menusArr[$value->id]["menu_title"] = $value->menu_title;
            $menusArr[$value->id]["url"] = Yii::app()->createUrl("admin/".$value->page_url);
            $menusArr[$value->id]["menu_icon"] = $value->menu_icon;
            list($pageController,$pageAction) = explode("/",$value->page_url);
            $menusArr[$value->id]["active"] = ($controller==$pageController)?true:false;
                if (!empty($value->childRel)): foreach ($value->childRel as $childValue): 
                    if(!empty($childValue->show_in_menu)):
                        $menusArr[ $value->id]["submenu"][] = array("menu_title" => $childValue->menu_title,"url" => Yii::app()->createUrl("admin/".$childValue->page_url),"active"=>($currentUrl==$childValue->page_url)?true:false);
                    endif;
            endforeach; endif;
        endforeach; endif; 
        return $menusArr;
    }
}
