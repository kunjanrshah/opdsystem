<?php

/**
 * This is the model class for table "menus_master".
 *
 * The followings are the available columns in table 'menus_master':
 * @property integer $id
 * @property string $menu_title
 * @property string $page_url
 * @property integer $parent_id
 * @property integer $show_in_menu
 * @property string $menu_icon
 * @property integer $deleted
 * @property integer $created_by
 * @property integer $created_dt
 * @property integer $updated_by
 * @property integer $updated_dt
 */
class MenusMaster extends CActiveRecord {

    public $parent_menu_title, $parent_page_url,$page_sort;
    public $show_in_menu = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MenusMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'menus_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('menu_title, page_url', 'required'),
            array('menu_title, page_url', 'unique', 'criteria' => array(
                    'condition' => 'parent_id!=:parent_id', 'params' => array(':parent_id' => 0)
                )),
            array('parent_id, show_in_menu, deleted, created_by, created_dt, updated_by, updated_dt', 'numerical', 'integerOnly' => true),
            array('menu_title, menu_icon', 'length', 'max' => 20),
            array('page_url', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, menu_title, page_url, parent_id, show_in_menu, menu_icon, deleted, created_by, created_dt, updated_by, updated_dt', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "parentRel" => array(self::BELONGS_TO, 'MenusMaster', 'parent_id'),
            "childRel" => array(self::HAS_MANY, 'MenusMaster', 'parent_id', "order" => "childRel.parent_id ASC")
        );
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        return array(
            'alias' => $alias,
            'condition' => "".$alias.".deleted=0 ",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord):
            $this->created_dt = common::getTimeStamp();
            $this->created_by = Yii::app()->user->id;
        else:
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = Yii::app()->user->id;
        endif;
        return parent::beforeSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'menu_title' => 'Menu Title',
            'page_url' => 'Page URL',
            'parent_id' => 'Parent Menu',
            'show_in_menu' => 'Show In Menu',
            'menu_icon' => 'Menu Icon',
            'deleted' => 'Deleted',
            'created_by' => 'Created By',
            'created_dt' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Date',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('parent_id NOT IN (0)', "AND");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'parent_id',
                ),
                'defaultOrder' => 'parent_id ASC, menu_title ASC',
            ),
            'pagination' => false
        ));
    }

    public function getParentMenus() {
        return MenusMaster::model()->findAllByAttributes(array("parent_id" => 0));
    }

}
