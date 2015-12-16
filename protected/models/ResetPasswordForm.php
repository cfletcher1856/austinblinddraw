<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ResetPasswordForm extends CFormModel
{
    public $password;
    public $confirm_password;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('password, confirm_password', 'required'),
            array('password', 'compare', 'compareAttribute'=>'confirm_password'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'password'=>'Password',
            'confirm_password' => 'Confirm Password'
        );
    }
}
