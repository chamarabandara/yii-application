<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
  $user = Users::model()->findByAttributes(array('username' => $this->username));

        if ($user != null) {
            //converting password for test
            $decriptedPw = md5($this->password + yii::app()->params['salt']);
        }

        if ($user === null) { // No user found!
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;
        } else if ($decriptedPw == $user->password) { // Okay!
            Yii::app()->user->setState('loggedUserId', $user->id);
            Yii::app()->user->setState('username', $user->username);
            //Yii::app()->user->setState('roleId', $user->role_id);
            $this->errorCode = self::ERROR_NONE;
            return true;
        } else { // Invalid password!
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;
        }

        return $this->errorCode;

	}
}