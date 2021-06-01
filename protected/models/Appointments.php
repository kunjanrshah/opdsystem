<?php

/**
 * This is the model class for table "appointments".
 *
 * The followings are the available columns in table 'appointments':
 * @property integer $id
 * @property string $appointment_title
 * @property integer $patient_id
 * @property integer $appointment_date
 * @property integer $is_confirmed
 * @property string $description
 * @property integer $token_number
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Appointments extends CActiveRecord {

    public $appointment_time, $appointment_time_db, $today, $is_treatment_given,$appointment_id;
    public $shiftTimeRange = array(
        0 => array("start" => "09:00:00", "end" => "14:00:00"),
        1 => array("start" => "17:00:00", "end" => "22:00:00")
    );
    public $start_date, $end_date;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Appointments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'appointments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('appointment_title, patient_id, appointment_date,appointment_time', 'required'),
            array('appointment_time', 'unique', 'criteria' => array(
                    'condition' => 'appointment_date=:appointment_date',
                    'params' => array(':appointment_date' => common::getTimeStamp($this->appointment_date)),
                )),
            array('patient_id', 'CheckAlready'),
            array('patient_id, is_confirmed, token_number, deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('appointment_title', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, appointment_title,start_date,end_date, patient_id, appointment_date, is_confirmed, description, token_number, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function CheckAlready() {
        if (!empty($this->patient_id) && empty($this->id)):
            $model = Appointments::model()->findByAttributes(array('patient_id' => $this->patient_id, 'is_treatment_given' => 0));
            if (!empty($model)):
                $this->addError("patient_id", "This patient has already taken appointment and not treated yet.");
            endif;
        endif;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "patientRel" => array(self::BELONGS_TO, "Patients", "patient_id"),
        );
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        $condition = (Yii::app()->user->isPatient) ? " AND $alias.patient_id='" . Yii::app()->user->id . "' " : "";
        return array(
            'condition' => "$alias.deleted = 0 " . $condition,
        );
    }

    protected function beforeSave() {
        if ($this->isNewRecord):
            $this->token_number = Appointments::model()->generateTokenNumber($this->appointment_date);
            $this->created_dt = common::getTimeStamp();
            $this->created_by = Yii::app()->user->id;
        else:
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = Yii::app()->user->id;
        endif;

        $this->appointment_time = common::getDateTime($this->appointment_time, "H:i:s");
        $this->appointment_date = common::getTimeStamp($this->appointment_date);
        //common::pr($this->attributes);exit;
        return parent::beforeSave();
    }

    protected function afterFind() {
        $this->appointment_time_db = $this->appointment_time;
        $this->appointment_time = common::getDateTime($this->appointment_time, Yii::app()->params->timeFormatPHP);
        $this->appointment_date = common::getDateTimeFromTimeStamp($this->appointment_date, Yii::app()->params->dateFormatPHP);
        return parent::afterFind();
    }

    public function scopes() {
        return array(
            'Confirmed' => array(
                'condition' => 'is_confirmed = 1',
            ),
        );
    }

    public function generateTokenNumber($date = null) {
        $date = !empty($dateTime) ? common::getDateTime($date, "m/d/Y") : common::getDateTime("now", "m/d/Y");
        $criteria = new CDbCriteria();
        $criteria->select = "MAX(id) AS id";
        $criteria->compare("FROM_UNIXTIME(t.appointment_date,'%m/%d/%Y')", $date);
        $count = self::model()->find($criteria)->id;
        return !empty($count) ? $count + 1 : 1;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'appointment_title' => 'Appointment Title',
            'patient_id' => 'Patient',
            'appointment_date' => 'Date',
            'appointment_time' => 'Time',
            'is_confirmed' => 'Is Confirmed',
            'description' => 'Description',
            'token_number' => 'Token Number',
            'deleted' => 'Deleted',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
            'start_date' => "Start Date",
            'end_date' => "End Date"
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

        if ($this->today) {
            $criteria->compare("FROM_UNIXTIME(t.appointment_date,'%d/%m/%Y')", common::getDateTime("now", "d/m/Y"));
            $this->is_treatment_given = 0;
        }

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $criteria->addCondition("t.appointment_date >= '" . $this->start_date . "'", 'AND');
            $criteria->addCondition("t.appointment_date <= '" . $this->end_date . "'", 'AND');
        } else {
            if (!empty($this->start_date)) {
                $criteria->addCondition("t.appointment_date  = '" . $this->start_date . "'", 'AND');
            } else if (!empty($this->end_date)) {
                $criteria->addCondition("t.appointment_date  = '" . $this->end_date . "'", 'AND');
            }
        }
        $criteria->compare("is_treatment_given", $this->is_treatment_given);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize,
            ), 'sort' => array('defaultOrder' => 'appointment_date DESC,appointment_time ASC, token_number ASC')
        ));
    }

    /* get appointment time range */

    public function getAppointmentTimeRange($appointment_date) {
        $appointment_date = common::getTimeStamp($appointment_date);
        $steps = 300;

        $start = common::hoursToSecods($this->shiftTimeRange[0]["start"]);
        $end = common::hoursToSecods($this->shiftTimeRange[0]["end"]);
        $shift1 = common::getTimeRange($start, $end, $steps);

        $start = common::hoursToSecods($this->shiftTimeRange[1]["start"]);
        $end = common::hoursToSecods($this->shiftTimeRange[1]["end"]);
        $shift2 = common::getTimeRange($start, $end, $steps);

        return array("Shift 1" => $shift1) + array("Shift 2" => $shift2);
    }

    /* fixed appointments */

    public function getFixedAppointments($appointment_date) {
        $appointment_date = common::getTimeStamp($appointment_date);
        $model = Appointments::model()->findAll("appointment_date=" . $appointment_date);

        $array = array();
        if (!empty($model)):
            foreach ($model as $value):
                //$array[$value->appointment_time_db]["disabled"] = true;
            endforeach;
        endif;
        return $array;
    }

    public function getAppointmentsList($patient_id = null) {
        return CHtml::ListData($this->findAllByAttributes(array('patient_id' => $patient_id)), "id", "appointment_title");
    }
	
	

}
