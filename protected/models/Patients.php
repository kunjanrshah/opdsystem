<?php

/**
 * This is the model class for table "patients".
 *
 * The followings are the available columns in table 'patients':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property integer $user_group
 * @property string $patient_name
 * @property string $profile_pic
 * @property integer $registration_date
 * @property integer $birth_date
 * @property string $patient_age
 * @property integer $gender
 * @property integer $family_id
 * @property string $relation
 * @property string $blood_group
 * @property integer $reference_by
 * @property string $address1
 * @property string $address2
 * @property integer $country_id
 * @property integer $state_id
 * @property string $city
 * @property integer $pin_code
 * @property string $contact_number
 * @property string $contact_number2
 * @property string $email_address
 * @property integer $status
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Patients extends CActiveRecord {

    const ACTIVE = 1;
    const IN_ACTIVE = 0;
    const MALE = 1;
    const FE_MALE = 0;
    const THUMB_SMALL = "small_";

    public $statusArr = array(self::ACTIVE, "Active", self::IN_ACTIVE => "In Active");
    public $genderArr = array(self::MALE => "Male", self::FE_MALE => "Female");
    public $profilePicThumbArr = array('150', '150'); //width,height
    public $relationArr = array(1 => "Father", 2 => "Mother", 3 => "Son", 4 => "Brother", 5 => "Sister", 6 => "Husband", 7 => "Wife", 8 => "Self", 9 => "Daughter", 10 => "Son IL", 11 => "Daughter IL", 12 => "Father IL", 13 => "Mother IL", 14 => "Brother IL", 15 => "Grand Daughter", 16 => "Grand Son");
    public $bloodGroupArr = array(1 => "A+ve", 2 => "A-ve", 3 => "B+ve", 4 => "B-ve", 5 => "AB+ve", 6 => "AB-ve", 7 => "O+ve", 8 => "O-ve");
    public $patient_age_years, $repeat_password, $patient_age_months, $patient_age_days, $patient_name_with_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Patients the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'patients';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('patient_name, username,registration_date,address1,city,password,repeat_password,status,patient_age', 'required', "on" => "add"),
            array('patient_name, username,registration_date,address1,city,status,patient_age', 'required', "on" => "update"),
            array("username,email_address", "unique"),
            array("email_address", "email"),
            array("relation", "validRelation"),
            array('password,repeat_password', 'required', 'on' => 'add'),
            array('profile_pic', 'file', 'allowEmpty' => true, 'types' => implode(",", Yii::app()->params->allowedImages)),
            array('repeat_password', 'compare', 'compareAttribute' => 'password', 'on' => 'add'),
            array('contact_number,contact_number2,user_group, gender, family_id, reference_by, country_id, state_id, pin_code, status, deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('username, patient_name, profile_pic, city', 'length', 'max' => 50),
            array('password, salt', 'length', 'max' => 255),
            array('address1', 'length', 'min' => 3),
            array('patient_age', 'length', 'max' => 10),
            array('relation, contact_number,contact_number2', 'length', 'max' => 10),
            array('blood_group', 'length', 'max' => 5),
            array('email_address', 'length', 'max' => 128),
            array('address1, address2,regular_medicine,other_case,allergy,patient_age', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username,contact_number2, password, salt, user_group, patient_name, profile_pic, registration_date, birth_date, patient_age, gender, family_id, relation, blood_group, reference_by, address1, address2, country_id, state_id, city, pin_code, contact_number, email_address, status, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    public function validRelation() {
        if (!empty($this->family_id) && empty($this->relation)) {
            $this->addError("relation", "Relation cannot be blank.");
        }
    }

    public function defaultScope() {

        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => "$alias.deleted = 0",
        );
    }

    protected function beforeSave() {
        $this->birth_date = !empty($this->birth_date) ? common::getTimeStamp($this->birth_date) : "";
        $this->registration_date = !empty($this->registration_date) ? common::getTimeStamp($this->registration_date) : "";
        if ($this->isNewRecord):
            $this->salt = $this->generateSalt();
            $this->password = $this->hashPassword($this->password, $this->salt);
            $this->repeat_password = $this->password;
            $this->created_dt = common::getTimeStamp();
            $this->created_by = Yii::app()->user->id;
            $this->deleted = 0;
        else:
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = Yii::app()->user->id;
        endif;
        $this->regular_medicine = @implode(",", $this->regular_medicine);
        $this->other_case = @implode(",", $this->other_case);
        $this->allergy = @implode(",", $this->allergy);
        //common::pr($this->attributes);exit;
        return parent::beforeSave();
    }

    protected function afterFind() {
        $this->birth_date = !empty($this->birth_date) ? common::getDateTimeFromTimeStamp($this->birth_date, Yii::app()->params->dateFormatPHP) : "";
        $this->registration_date = !empty($this->registration_date) ? common::getDateTimeFromTimeStamp($this->registration_date, Yii::app()->params->dateFormatPHP) : "";
        $this->patient_name_with_id = $this->id . " - " . $this->patient_name . " - " . $this->contact_number;
        $this->regular_medicine = @explode(",", $this->regular_medicine);
        $this->other_case = @explode(",", $this->other_case);
        $this->allergy = @explode(",", $this->allergy);
        return parent::afterFind();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "familyRel" => array(self::BELONGS_TO, 'Patients', 'family_id'),
            "referenceRel" => array(self::BELONGS_TO, 'ReferencesMaster', 'reference_by'),
            "AreaRel" => array(self::BELONGS_TO, "AreaMaster", "address2"),
            "allergyRel" => array(self::BELONGS_TO, "AllergyMaster", "allergy"),
            "knownCaseRel" => array(self::BELONGS_TO, "CaseMaster", "other_case"),
            "regurlarMedicine" => array(self::BELONGS_TO, "MedicineMaster", "regular_medicine"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'Patient ID',
            'username' => 'Username',
            'password' => 'Password',
            'salt' => 'Salt',
            'user_group' => 'User Group',
            'patient_name' => 'Patient Fullname',
            'profile_pic' => 'Patient Photo',
            'registration_date' => 'Registration Date',
            'birth_date' => 'Birth Date',
            'patient_age' => 'Age',
            'patient_age_years' => 'Years',
            'patient_age_months' => 'Months',
            'patient_age_days' => 'Days',
            'gender' => 'Gender',
            'family_id' => 'Family Head',
            'relation' => 'Relation',
            'blood_group' => 'Blood Group',
            'reference_by' => 'Reference',
            'address1' => 'Address',
            'address2' => 'Area',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city' => 'City',
            'pin_code' => 'PIN Code',
            'contact_number' => 'Contact Number',
            'contact_number2' => 'Contact Number 2',
            'email_address' => 'Email Address',
            'status' => 'Status',
            'deleted' => 'Deleted',
            'created_dt' => 'Created Dt',
            'created_by' => 'Created By',
            'updated_dt' => 'Updated Dt',
            'updated_by' => 'Updated By',
            'other_case' => 'Known Case of'
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
        $criteria->compare("t.id", $this->id);
        $criteria->compare("t.family_id", $this->family_id);
        $criteria->compare("t.city", $this->city, true);
        $criteria->compare("t.address1", $this->address1, true);
        $criteria->compare("AreaRel.area_name", $this->address2, true);
        $criteria->compare("t.blood_group", $this->blood_group);
        $criteria->compare("t.contact_number", $this->contact_number, true);
        $criteria->with = array("AreaRel", "familyRel");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize,
            ), 'sort' => array('defaultOrder' => 't.patient_name ASC')
        ));
    }

    public function getProfilePicture($profile_pic = null, $id = null) {
        $uploadPath = Yii::app()->params->paths['patientsPath'] . $id . "/";
        if (!empty($profile_pic) && file_exists($uploadPath . $profile_pic)) {
            return Yii::app()->params->paths['patientsURL'] . $id . "/" . $profile_pic;
        } else {
            return Yii::app()->params->ADMIN_BT_URL . "image/avatar/avatar.png";
        }
    }

    /* Function For upload profile picture with thumb */

    public function uploadProfilePicture($model) {
        $profile_pic = CUploadedFile::getInstance($model, 'profile_pic');
        $directoryPath = Yii::app()->params->paths['patientsPath'] . $model->id . "/";
        if (common::checkAndCreateDirectory($directoryPath) && !empty($profile_pic)) {
            $profile_pic->saveAs($directoryPath . $profile_pic->getName());
            $origionalPath = $directoryPath . $profile_pic->getName();
            $thumbProfilePic = Users::THUMB_SMALL . $profile_pic->getName();
            $thumbPath = $directoryPath . $thumbProfilePic;
            $image = Yii::app()->image->load($origionalPath);
            $profilePicThumbArr = Users::model()->profilePicThumbArr;
            $image->resize($profilePicThumbArr[0], $profilePicThumbArr[1]);
            $image->save($thumbPath);
            return $thumbProfilePic;
        } else {
            return $model->profile_pic;
        }
    }

    public function getUpcomingPatients() {
        $date = common::getDateTime("now", "d/m/Y");
        $criteria = new CDbCriteria();
        $criteria->compare("FROM_UNIXTIME(t.appointment_date,'%d/%m/%Y')", $date);
        $criteria->compare("patientRel.deleted", 0);
        $criteria->compare("is_treatment_given", 0);
        $criteria->order = "'appointment_date ASC, token_number ASC'";
        return Appointments::model()->Confirmed()->with("patientRel")->findAll($criteria);
    }

    public function getPatientsList() {
        return CHtml::ListData($this->findAll(), "id", "patient_name");
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($password, $salt) {
        return md5($salt . $password);
    }

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    public function generateSalt() {
        return uniqid('', true);
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
    }

    public function getPatientLastTreatment($patient_id) {
        $criteria = new CDbCriteria();
        $criteria->order = "id DESC";
        $criteria->compare("patient_id", $patient_id);
        return Treatments::model()->find($criteria);
    }

    public function getPatientTreatments($patient_id) {
        $criteria = new CDbCriteria();
        $criteria->order = "id DESC";
        $criteria->compare("patient_id", $patient_id);
        return Treatments::model()->findAll($criteria);
    }

    public function getFamilyHead() {
        $criteria = new CDbCriteria();
        $criteria->condition = 'family_id=0';
        return Patients::model()->findAll();
    }

}
