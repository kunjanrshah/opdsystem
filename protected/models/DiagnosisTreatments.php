<?php

/**
 * This is the model class for table "diagnosis_treatments".
 *
 * The followings are the available columns in table 'diagnosis_treatments':
 * @property integer $id
 * @property integer $diagnosis_id
 * @property integer $medicine_id
 * @property integer $doseage_id
 */
class DiagnosisTreatments extends CActiveRecord {

    public $medicine_group_id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosisTreatments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'diagnosis_treatments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosis_id, medicine_id, doseage_id, medicine_group_id', 'required'),
            array('medicine_group_id', 'safe'),
            array('diagnosis_id, medicine_id, doseage_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, diagnosis_id, medicine_id, doseage_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "medicineGroupRel" => array(self::BELONGS_TO, "MedicineGroupMaster", "medicine_group_id"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'diagnosis_id' => 'Diagnosis',
            'medicine_id' => 'Medicine',
            'doseage_id' => 'Doseage',
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
        $criteria->compare('diagnosis_id', $this->diagnosis_id);
        $criteria->compare('medicine_id', $this->medicine_id);
        $criteria->compare('doseage_id', $this->doseage_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
