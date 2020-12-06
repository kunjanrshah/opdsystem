<?php

/**
 * This is the model class for table "notifications".
 *
 * The followings are the available columns in table 'notifications':
 * @property integer $id
 * @property integer $user_id
 * @property string $description
 * @property string $link
 * @property integer $is_read
 * @property integer $created_dt
 * @property integer $updated_dt
 * @property integer $created_by
 * @property integer $updated_by
 */
class Notifications extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Notifications the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'notifications';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, description, link, created_dt, updated_dt, created_by, updated_by', 'required'),
            array('user_id, is_read, created_dt, updated_dt, created_by, updated_by', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('deleted', 'safe'),
            array('id, user_id, description, link, is_read, created_dt, updated_dt, created_by, updated_by', 'safe', 'on' => 'search'),
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

    public function afterFind() {
        $this->link = $this->link . "&Notifications[is_read]=1&Notifications[id]=" . $this->id;
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
            'user_id' => 'User',
            'description' => 'Description',
            'link' => 'Link',
            'is_read' => 'Is Read',
            'created_dt' => 'Created Dt',
            'updated_dt' => 'Updated Dt',
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

        $criteria->compare('user_id', Yii::app()->user->id);
        $criteria->compare('is_read', 0);
        $criteria->compare('deleted', 0);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function totalNotifications($user_id) {
        $criteria = new CDbCriteria();
        $criteria->condition = "t.user_id=:user_id AND t.is_read=:is_read AND t.deleted=:deleted";
        $criteria->params = array(":user_id" => $user_id, ":is_read" => 0, ":deleted" => 0);
        return self::model()->count($criteria);
    }

    public function setRead() {

        $is_read = !empty($_GET['Notifications']['is_read']) ? $_GET['Notifications']['is_read'] : "";
        $id = !empty($_GET['Notifications']['id']) ? $_GET['Notifications']['id'] : "";
        if (!empty($is_read) && !empty($id)) {
            $model = Notifications::model()->findByPk($id);
            $model->is_read = $is_read;
            $model->update();
        }
    }
	
	public function setClearall($user_id) {

        $criteria = new CDbCriteria();
        $criteria->condition = "t.user_id=:user_id AND t.is_read=:is_read AND t.deleted=:deleted";
        $criteria->params = array(":user_id" => $user_id, ":is_read" => 0, ":deleted" => 0);
		if(Notifications::model()->updateAll(array('deleted' => 1),'user_id = "'.$user_id.'" AND is_read=0 AND deleted=0')){
			return true;
		}	
		
    }

}
