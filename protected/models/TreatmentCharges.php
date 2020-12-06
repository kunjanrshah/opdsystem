<?php

/**
 * This is the model class for table "treatment_charges".
 *
 * The followings are the available columns in table 'treatment_charges':
 * @property integer $id
 * @property integer $treatment_id
 * @property integer $charge_id
 * @property double $amount
 */
class TreatmentCharges extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TreatmentCharges the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'treatment_charges';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('treatment_id, charge_id, amount', 'required'),
            array('treatment_id, charge_id', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, treatment_id, charge_id, amount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            "chargeRel" => array(self::BELONGS_TO, "ChargesMaster", "charge_id"),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'treatment_id' => 'Treatment',
            'charge_id' => 'Charge',
            'amount' => 'Amount',
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
        $criteria->compare('charge_id', $this->charge_id);
        $criteria->compare('amount', $this->amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
