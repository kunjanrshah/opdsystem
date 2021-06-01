<?php

/**
 * This is the model class for table "charges_master".
 *
 * The followings are the available columns in table 'charges_master':
 * @property integer $id
 * @property string $charge_title
 * @property double $amount
 * @property integer $deleted
 * @property integer $created_dt
 * @property integer $updated_dt
 * @property integer $created_by
 * @property integer $updated_by
 */
class ChargesMaster extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ChargesMaster the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'charges_master';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('charge_title, amount', 'required'),
            array('deleted, created_dt, updated_dt, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical'),
            array('charge_title', 'length', 'max' => 128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, charge_title, amount, deleted, created_dt, updated_dt, created_by, updated_by', 'safe', 'on' => 'search'),
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
        return array(
            'alias' => $this->getTableAlias(false, false),
            'condition' => "deleted=0 ",
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
            'charge_title' => 'Charge Title',
            'amount' => 'Amount',
            'deleted' => 'Deleted',
            'created_dt' => 'Created Date',
            'updated_dt' => 'Updated Date',
            'created_by' => 'Created By',
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
        $criteria->compare('charge_title', $this->charge_title, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('created_dt', $this->created_dt);
        $criteria->compare('updated_dt', $this->updated_dt);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('updated_by', $this->updated_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params->defaultPageSize,
            )
        ));
    }

}
