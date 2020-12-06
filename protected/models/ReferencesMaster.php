<?php

/**
 * This is the model class for table "references_master".
 *
 * The followings are the available columns in table 'references_master':
 * @property integer $id
 * @property string $reference_name
 * @property integer $reference_type
 * @property string $profession
 * @property string $address1
 * @property string $address2
 * @property integer $country_id
 * @property integer $state_id
 * @property string $city
 * @property string $contact_number
 * @property string $fax
 * @property integer $pin_code
 * @property string $email_address
 * @property string $website
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $created_by
 * @property integer $updated_dt
 * @property integer $updated_by
 */
class ReferencesMaster extends CActiveRecord {

    public $referenceTypeArr = array(1 => "Doctor", 2 => "Patients", 3 => "Others");
    public $ref_name_with_contact;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ReferencesMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'references_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('reference_name, profession,contact_number', 'required'),
            array("reference_name,contact_number", "unique"),
            array("email_address", "email"),
            array("website", "url"),
            array('reference_type, country_id, state_id, pin_code, deleted, created_dt, created_by, updated_dt, updated_by', 'numerical', 'integerOnly' => true),
            array('reference_name, profession, city', 'length', 'max' => 50),
            array('contact_number, fax', 'length', 'max' => 20),
            array('email_address', 'length', 'max' => 128),
            array('website', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, reference_name, reference_type, profession, address1, address2, country_id, state_id, city, contact_number, fax, pin_code, email_address, website, deleted, created_dt, created_by, updated_dt, updated_by', 'safe', 'on' => 'search'),
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

    protected function afterFind() {
        $this->ref_name_with_contact = $this->reference_name . " " . $this->contact_number;
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
            'reference_name' => 'Reference Name',
            'reference_type' => 'Reference Type',
            'profession' => 'Profession',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'country_id' => 'Country',
            'state_id' => 'State',
            'city' => 'City',
            'contact_number' => 'Contact Number',
            'fax' => 'Fax',
            'pin_code' => 'Pin Code',
            'email_address' => 'Email Address',
            'website' => 'Website',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('reference_name', $this->reference_name, true);
        $criteria->compare('reference_type', $this->reference_type);
        $criteria->compare('profession', $this->profession, true);
        $criteria->compare('address1', $this->address1, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('contact_number', $this->contact_number, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('pin_code', $this->pin_code);
        $criteria->compare('email_address', $this->email_address, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_dt', $this->updated_dt);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
