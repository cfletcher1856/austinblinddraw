<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_NOT_ACTIVE = 'Director is not active.';
	private $_id;
	private $_user;

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
		$username = strtolower($this->username);
		$this->_user = $user = User::model()->find('LOWER(email)=? and password=?', array($username, md5($this->password)));

		if($user === null){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} elseif(!$user->validatePassword($this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} elseif($user->active != 1){
			$this->errorCode = self::ERROR_NOT_ACTIVE;
		} else {
			$this->_id = $user->id;
			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function get_redirect()
	{
		return $this->_user->redirect;
	}
}
