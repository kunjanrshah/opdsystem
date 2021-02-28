<?php

/**
 * This is the model class for table "medicine_master".
 *
 * The followings are the available columns in table 'medicine_master':
 * @property integer $id
 * @property string $medicine_name
 * @property integer $drug_id
 * @property integer $is_internal
 * @property integer $medicine_type
 * @property integer $dosages
 * @property string $dosages_remarks
 * @property string $duration_in_days
 * @property integer $company_id
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class MedicineMaster extends CActiveRecord {

    const INTERNAL = 1;
    const EXTERNAL = 2;
    public $isInternalArr = array(self::INTERNAL => "Yes", self::EXTERNAL=> "No");
    public $medicineTypeArr = array(1 => "Type1", 2 => "Type2");
    public $start_date, $end_date, $medicine_name_with_type, $medicine_name_with_company,$group_id,$medicine_name_with_group;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MedicineMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'medicine_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('group_id,medicine_name, drug_id, is_internal, company_id', 'required'),
            array('drug_id, is_internal, medicine_type, dosages, company_id, deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array("medicine_name", "unique"),
            array('medicine_name', 'length', 'max' => 128),
            array('duration_in_days', 'length', 'max' => 10),
            array('group_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, medicine_name,is_vaccine,stock, drug_id, is_internal, medicine_type, dosages, dosages_remarks, duration_in_days, company_id, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "drugRel" => array(self::BELONGS_TO, "DrugsMaster", "drug_id"),
            "companyRel" => array(self::BELONGS_TO, "CompanyMaster", "company_id"),
            "groupRel" => array(self::BELONGS_TO, "MedicineGroupMaster", "group_id"),
        );
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        return array(
            'alias' => $alias,
            'condition' => "" . $alias . ".deleted=0 ",
        );
    }

    public function afterFind() {
        $type = ($this->is_internal == 1) ? "Internal" : "External";
        $this->medicine_name_with_type = $this->medicine_name . " (" . $type . ")";
        $company_name = !empty($this->companyRel->company_name)? " (" . $this->companyRel->company_name . ")" : '';
        $this->medicine_name_with_company = $this->medicine_name . $company_name;
        $group_name = !empty($this->groupRel->name)? " (" . $this->groupRel->name . ")" : '';
        $this->medicine_name_with_group = $this->medicine_name . $group_name;

        return parent::afterFind();
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
            'medicine_name' => 'Medicine Name',
            'group_id' => 'Group',
            'drug_id' => 'Drug',
            'is_internal' => 'Is Internal',
            'medicine_type' => 'Medicine Type',
            'dosages' => 'Dosages',
            'dosages_remarks' => 'Dosages Remarks',
            'duration_in_days' => 'Duration In Days',
            'company_id' => 'Company',
            'is_vaccine' => "Vaccine ?",
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
        $criteria->compare('medicine_name',$this->medicine_name,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
