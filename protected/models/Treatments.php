<?php

/**
 * This is the model class for table "treatments".
 *
 * The followings are the available columns in table 'treatments':
 * @property integer $id
 * @property integer $appointment_id
 * @property integer $patient_id
 * @property integer $patient_height
 * @property integer $patient_width
 * @property integer $patient_bmi
 * @property integer $patient_pressure
 * @property integer $patient_pulse
 * @property integer $patient_temp
 * @property integer $patient_resp
 * @property integer $patient_waist
 * @property integer $patient_hip
 * @property string $remarks
 * @property string $diagnosis_id
 * @property string $complains_id
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Treatments extends CActiveRecord {

    public $start_date, $end_date, $today, $is_treatment_given;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Treatments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'treatments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('appointment_id, patient_id, diagnosis_id, complains_id', 'required'),
            array('appointment_id, patient_id,deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('diagnosis_id, complains_id', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,debit_amount,credit_amount,appointment_id, patient_id, patient_height, patient_width, patient_bmi, patient_pressure, patient_pulse, patient_temp, patient_resp, patient_waist, patient_hip, remarks, diagnosis_id, complains_id, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "diagnosisRel" => array(self::BELONGS_TO, "DiagnosisMaster", "diagnosis_id"),
            "patientRel" => array(self::BELONGS_TO, "Patients", "patient_id"),
            "treatmentDetailsRel" => array(self::HAS_MANY, "TreatmentDetails", "treatment_id"),
            "treatmentChargesRel" => array(self::HAS_MANY, "TreatmentCharges", "treatment_id"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'appointment_id' => 'Appointment',
            'patient_id' => 'Patient',
            'patient_height' => 'Patient Height',
            'patient_width' => 'Patient Weight',
            'patient_bmi' => 'Patient Sugar',
            'patient_pressure' => 'Patient Pressure',
            'patient_pulse' => 'Patient Pulse',
            'patient_temp' => 'Patient Temp',
            'patient_resp' => 'Patient Resp',
            'patient_waist' => 'Patient Waist',
            'patient_hip' => 'Patient Hip',
            'remarks' => 'Remarks',
            'diagnosis_id' => 'Diagnosis',
            'complains_id' => 'Complains',
            'deleted' => 'Deleted',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
        );
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => "$alias.deleted = 0",
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord):
            $this->created_by = Yii::app()->user->id;
            $this->deleted = 0;
            $this->created_dt = common::getTimeStamp("", "Y-m-d H:i:s");
        else:
            $this->updated_dt = common::getTimeStamp("", "Y-m-d H:i:s");
            $this->updated_by = Yii::app()->user->id;
        endif;
        $this->complains_id = (!empty($this->complains_id) && is_array($this->complains_id)) ? implode(",", $this->complains_id) : $this->complains_id;
        $this->diagnosis_id = (!empty($this->diagnosis_id) && is_array($this->diagnosis_id)) ? implode(",", $this->diagnosis_id) : $this->diagnosis_id;
        //common::pr($this->attributes);exit;
        return parent::beforeSave();
    }

    public function beforeValidate() {
        $this->complains_id = (!empty($this->complains_id) && is_array($this->complains_id)) ? implode(",", $this->complains_id) : $this->complains_id;
        $this->diagnosis_id = (!empty($this->diagnosis_id) && is_array($this->diagnosis_id)) ? implode(",", $this->diagnosis_id) : $this->diagnosis_id;
        return parent::beforeValidate();
    }

    public function afterFind() {
        $this->complains_id = !empty($this->complains_id) ? explode(",", $this->complains_id) : array();
        //$this->diagnosis_id = !empty($this->diagnosis_id) ? explode(",", $this->diagnosis_id) : array();
        $this->created_dt = common::getDateTimeFromTimeStamp($this->created_dt, "d/m/Y H:i A");
        return parent::afterFind();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        if ($this->today):
            $criteria->compare('FROM_UNIXTIME(created_dt,"%d/%m/%Y")', common::getDateTime("now", "d/m/Y"));
        endif;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ), 'sort' => array('defaultOrder' => "id DESC")
        ));
    }

    public function getTodaysTreatments() {
        $today = common::getTimeStamp();
        return self::model()->findAllByAttributes(array("created_dt" => $today));
    }

}
