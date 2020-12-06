<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity {

    private $_id;
    public $isPatient;
    
    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $modelName = ($this->isPatient)?"Patients":"Users";
        $user = $modelName::model()->find('LOWER(username)=:username OR email_address=:email_address', array(":username" => strtolower($this->username), "email_address" => strtolower($this->username)));

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
         else if (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }
         else if ($user->status != Users::ACTIVE) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;
            Yii::app()->user->setState("user_group", $user->user_group);
            Yii::app()->user->setState("isPatient", $this->isPatient);
            $_SESSION["is_backen_login"] = true;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}
