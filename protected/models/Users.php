<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $repeat_password
 * @property string $salt
 * @property string $email_address
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $phone_number
 * @property integer $gender
 * @property integer $birth_date
 * @property string $address
 * @property integer $country_id
 * @property integer $state_id
 * @property string $city
 * @property integer $zipcode
 * @property string $profile_pic
 * @property integer $user_group
 * @property integer $status
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class Users extends CActiveRecord {
	const ACTIVE = 1;
    const IN_ACTIVE = 0;
    const MALE = 1;
    const FE_MALE = 0;
    const THUMB_SMALL = "small_";

    public $statusArr = array(self::ACTIVE, "Active", self::IN_ACTIVE => "In Active");
    public $genderArr = array(self::MALE=>"Male", self::FE_MALE => "Female");
    public $profilePicThumbArr = array('150', '150'); //width,height
    public $repeat_password;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function defaultScope() 
    {
        return array(
            'alias' => $this->getTableAlias(false, false),
            'condition' => "deleted=0 ",
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    protected function beforeSave() {
        if ($this->isNewRecord):
            $this->salt = $this->generateSalt();
            $this->password = $this->hashPassword($this->password, $this->salt);
            $this->repeat_password = $this->password;
            $this->created_dt = common::getTimeStamp();
            $this->created_by = Yii::app()->user->id;
        else:
            $this->updated_dt = common::getTimeStamp();
            $this->updated_by = Yii::app()->user->id;
        endif;
        return parent::beforeSave();
    }
    protected function afterFind() {
        $this->birth_date = !empty($this->birth_date)?common::getDateTimeFromTimeStamp($this->birth_date,Yii::app()->params->dateFormatPHP):"";
        return parent::afterFind();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username,email_address, first_name, last_name,country_id,state_id,city,gender,user_group', 'required'),
            array("username,email_address", "unique"),
            array("email_address","email"),
            array('password,repeat_password', 'required', 'on' => 'add'),
            array('password,repeat_password', 'safe', 'on' => 'update'),
            array('profile_pic', 'file','allowEmpty'=>true,'types'=>implode(",",Yii::app()->params->allowedImages)),
            array('repeat_password', 'compare', 'compareAttribute' => 'password'),
//            array('repeat_password', 'compare', 'compareAttribute' => 'password', 'on' => 'add'),
            array('gender, country_id, state_id, zipcode, user_group, status, deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('username, first_name, middle_name, last_name', 'length', 'max' => 50),
            array('password, salt', 'length', 'max' => 255),
            array('email_address, city', 'length', 'max' => 100),
            array('phone_number', 'length', 'max' => 20),
            array('profile_pic', 'length', 'max' => 128),
            array('address', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, repeat_password,salt, email_address, first_name, middle_name, last_name, phone_number, gender, birth_date, address, country_id, state_id, city, zipcode, profile_pic, user_group, status, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "usersGroupRel" => array(self::BELONGS_TO, "UsersGroup", "user_group")
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'repeat_password' => 'Repeat Password',
            'salt' => 'Salt',
            'email_address' => 'Email Address',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'phone_number' => 'Phone Number',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'address' => 'Address',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city' => 'City',
            'zipcode' => 'Zipcode',
            'profile_pic' => 'Profile Pic',
            'user_group' => 'User Group',
            'status' => 'Status',
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
 
        if(!Yii::app()->user->isSuperAdmin()){
             $criteria->condition = "t.user_group != ".UsersGroup::SUPER_ADMIN;
        }        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize,
            ),
            'sort' => array(
                'defaultOrder' => 'id ASC',
            ),
        ));
    }

    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password) {
        return $this->hashPassword($password, $this->salt) === $this->password;
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
    /*Function for check admin is logged or not*/
    public function isAdminLoggedIn() {
        Yii::app()->user->loadWebUser();
        return (!empty(Yii::app()->user->id)) ? true : false;
    }
    /*Function For upload profile picture with thumb*/
    public function uploadProfilePicture($model) {
        $profile_pic = CUploadedFile::getInstance($model, 'profile_pic');
        $directoryPath = Yii::app()->params->paths['usersPath'] . $model->id . "/";
        if (common::checkAndCreateDirectory($directoryPath) && !empty($profile_pic)) {
            $profile_pic->saveAs($directoryPath . $profile_pic->getName());
            $origionalPath  = $directoryPath.$profile_pic->getName();
            $thumbProfilePic = Users::THUMB_SMALL.$profile_pic->getName();
            $thumbPath      = $directoryPath.$thumbProfilePic;
            $image = Yii::app()->image->load($origionalPath);
            $profilePicThumbArr = Users::model()->profilePicThumbArr;
            $image->resize($profilePicThumbArr[0], $profilePicThumbArr[1]);
            $image->save($thumbPath);
            return $thumbProfilePic;
        } else {
            return $model->profile_pic;
        }
    }
}
