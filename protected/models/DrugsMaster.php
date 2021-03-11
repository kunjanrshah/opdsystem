<?php

/**
 * This is the model class for table "drugs_master".
 *
 * The followings are the available columns in table 'drugs_master':
 * @property integer $id
 * @property string $drug_name
 * @property string $drug_desctiption
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class DrugsMaster extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DrugsMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'drugs_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('drug_name, drug_desctiption', 'required'),
            array('deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('drug_name', 'length', 'max' => 128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, drug_name, drug_desctiption, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        return array(
            'alias' => $alias,
            'condition' => "" . $alias . ".deleted=0 ",
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
            'drug_name' => 'Drug Name',
            'drug_desctiption' => 'Drug Desctiption',
            'deleted' => 'Deleted',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
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
        $criteria->select = "t.*, REPLACE(REPLACE(REPLACE(REPLACE(t.drug_name, 'Syp.', '') , 'Tab.', '') , 'Cap.', ''), 'Inj.', '') AS newMedicineName";

        $criteria->compare('id', $this->id);
        $criteria->compare('drug_name', $this->drug_name, true);
        $criteria->compare('drug_desctiption', $this->drug_desctiption, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_dt', $this->updated_dt);
        $criteria->compare('updated_by', $this->updated_by);

        $sort = new CSort();
        $sort->attributes = array(
                'drug_name'=>array(
                        'asc'=>'newMedicineName ASC',
                        'desc'=>'newMedicineName DESC',
                ),
                '*', // this adds all of the other columns as sortable
        );
        $sort->defaultOrder = 'newMedicineName ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }
    public function getDrugs(){
      $criteria = new CDbCriteria;
      $criteria->select = "t.*, REPLACE(REPLACE(REPLACE(REPLACE(t.drug_name, 'Syp.', '') , 'Tab.', '') , 'Cap.', ''), 'Inj.', '') AS newMedicineName";
      $criteria->order = "newMedicineName ASC";
      return DrugsMaster::model()->findAll($criteria);
    }
}
