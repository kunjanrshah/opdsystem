<<<<<<< HEAD
<?php

/**
 * This is the model class for table "diagnosis_master".
 *
 * The followings are the available columns in table 'diagnosis_master':
 * @property integer $id
 * @property integer $parent_id
 * @property string $diagnosis_title
 * @property string $complains
 * @property integer $deleted
 * @property string $description
 */
class DiagnosisMaster extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosisMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'diagnosis_master';
    }

    public function beforeValidate() {
        $this->complains = !empty($this->complains) ? @implode(",", $this->complains) : "";
        return parent::beforeValidate();
    }

    public function beforeSave() {
        $this->complains = (!empty($this->complains) && is_array($this->complains)) ? @implode(",", $this->complains) : $this->complains;
        return parent::beforeSave();
    }

    public function afterFind() {
        $this->complains = !empty($this->complains) ? explode(",", $this->complains) : array();
        return parent::afterFind();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosis_title, complains', 'required'),
            array('parent_id, deleted', 'numerical', 'integerOnly' => true),
            array('diagnosis_title, complains', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, parent_id, diagnosis_title, complains, deleted, description', 'safe', 'on' => 'search'),
        );
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        return array(
            'alias' => $alias,
            'condition' => "" . $alias . ".deleted=0 ",
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                //"DiagnosisTreatments" => array( self::HAS_MANY,"DiagnosisTreatments","id")
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'parent_id' => 'Parent',
            'diagnosis_title' => 'Diagnosis Title',
            'complains' => 'Complains',
            'deleted' => 'Deleted',
            'description' => 'Description',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('diagnosis_title', $this->diagnosis_title, true);
        $criteria->compare('complains', $this->complains, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize,
            )
        ));
    }

    public function getDiagnosis() {
        return $this->findAll(array('order'=>'diagnosis_title'));
    }

    public function getDiagnosisList() {
        return CHtml::ListData($this->getDiagnosis(), "id", "diagnosis_title");
    }
}
=======
<?php

/**
 * This is the model class for table "diagnosis_master".
 *
 * The followings are the available columns in table 'diagnosis_master':
 * @property integer $id
 * @property integer $parent_id
 * @property string $diagnosis_title
 * @property string $complains
 * @property integer $deleted
 * @property string $description
 */
class DiagnosisMaster extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosisMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'diagnosis_master';
    }

    public function beforeValidate() {
        $this->complains = !empty($this->complains) ? @implode(",", $this->complains) : "";
        return parent::beforeValidate();
    }

    public function beforeSave() {
        $this->complains = (!empty($this->complains) && is_array($this->complains)) ? @implode(",", $this->complains) : $this->complains;
        return parent::beforeSave();
    }

    public function afterFind() {
        $this->complains = !empty($this->complains) ? explode(",", $this->complains) : array();
        return parent::afterFind();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosis_title, complains', 'required'),
            array('parent_id, deleted', 'numerical', 'integerOnly' => true),
            array('diagnosis_title, complains', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, parent_id, diagnosis_title, complains, deleted, description', 'safe', 'on' => 'search'),
        );
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        return array(
            'alias' => $alias,
            'condition' => "" . $alias . ".deleted=0 ",
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                //"DiagnosisTreatments" => array( self::HAS_MANY,"DiagnosisTreatments","id")
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'parent_id' => 'Parent',
            'diagnosis_title' => 'Diagnosis Title',
            'complains' => 'Complains',
            'deleted' => 'Deleted',
            'description' => 'Description',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('diagnosis_title', $this->diagnosis_title, true);
        $criteria->compare('complains', $this->complains, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize,
            )
        ));
    }

    public function getDiagnosis() {
        return $this->findAll(array('order'=>'diagnosis_title'));
    }

    public function getDiagnosisList() {
        return CHtml::ListData($this->getDiagnosis(), "id", "diagnosis_title");
    }
}
>>>>>>> 3f0edeaa6006965f14e48f2366c4a164304fcfae
