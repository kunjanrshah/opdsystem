<?php

/**
 * This is the model class for table "treatment_details".
 *
 * The followings are the available columns in table 'treatment_details':
 * @property integer $id
 * @property integer $treatment_id
 * @property integer $medicine_id
 * @property integer $doseage_id
 */
class TreatmentDetails extends CActiveRecord {
    public $days;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TreatmentDetails the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'treatment_details';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('treatment_id, medicine_id, doseage_id', 'required'),
            array('treatment_id, medicine_id, doseage_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, treatment_id, medicine_id, doseage_id,days', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "medicineRel"=>array(self::BELONGS_TO,"MedicineMaster","medicine_id"),
            "doseageRel"=>array(self::BELONGS_TO,"DosagesMaster","doseage_id"),
            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'treatment_id' => 'Treatment',
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
        $criteria->compare('treatment_id', $this->treatment_id);
        $criteria->compare('medicine_id', $this->medicine_id);
        $criteria->compare('doseage_id', $this->doseage_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize,
            )
        ));
    }

}
