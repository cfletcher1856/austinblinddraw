<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $f_name
 * @property string $l_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property integer $active
 * @property integer $level
 * @property string $redirect
 * @property string $reset_token
 * @property integer $reset_time
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('f_name, l_name, email, password, phone, active', 'required'),
			array('active, level, reset_time', 'numerical', 'integerOnly'=>true),
			array('f_name, l_name, email', 'length', 'max'=>120),
			array('password, reset_token', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>15),
			array('redirect', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, f_name, l_name, email, password, phone, active, level, redirect, reset_token, reset_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'f_name' => 'First Name',
			'l_name' => 'Last Name',
			'email' => 'Email',
			'password' => 'Password',
			'phone' => 'Phone',
			'active' => 'Active',
			'level' => 'Level',
			'redirect' => 'Redirect',
			'reset_token' => 'Reset Token',
			'reset_time' => 'Reset Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('f_name',$this->f_name,true);
		$criteria->compare('l_name',$this->l_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('level',$this->level);
		$criteria->compare('redirect',$this->redirect,true);
		$criteria->compare('reset_token',$this->reset_token,true);
		$criteria->compare('reset_time',$this->reset_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
    {
        if(md5($password) == $this->password){
            return true;
        }

        return false;
    }

	public function activeChar()
	{
        return ($this->active) ? 'Y' : 'N';
    }

    public function getFullName()
    {
    	return "{$this->f_name} {$this->l_name}";
    }
}
