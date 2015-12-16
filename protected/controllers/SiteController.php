<?php

Yii::import('application.modules.director.models.Tournament');

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	public function actionBracket()
	{
		$date = new DateTime();
		$today = $date->format('Y-m-d');
		$tournament = Tournament::model()->findAll(array(
			'conditions' => 'started > :started and date = :date',
			'params' => array(':started' => 0, ':date' => $today)
		));
		$this->render('bracket', array(
			'tournament' => $tournament
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				$this->redirect(array($model->get_redirect()));
			}
		}
		// display the login form
		$model->password = '';
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionForgotPassword()
	{
		$model = new ForgotPasswordForm;

		if(isset($_POST['ForgotPasswordForm']))
		{
			$model->attributes=$_POST['ForgotPasswordForm'];

			// validate user input and redirect to the previous page if valid
			if($model->set_reset_token($this))
			{
				$this->redirect(array('//login'));
			}
		}

		$this->render('forgot_password', array(
			'model' => $model
		));
	}

	public function actionResetPassword($uuid)
	{
		$model = new ResetPasswordForm;

		$user = User::model()->findByAttributes(array(
			'reset_token' => $uuid
		));

		if(isset($_POST['ResetPasswordForm']) && !is_null($user))
		{
			$user->password = md5($_POST['ResetPasswordForm']['password']);
			$user->reset_token = null;
			$user->reset_time = null;
			if($user->save()){
				Yii::app()->user->setFlash('success', 'Your password has been updated.  Please login now.');
				$this->redirect(array('//login'));
			}

			Yii::app()->user->setFlash('error', 'There was a problem resetting your password.  Please try again.');
		}

		if(is_null($user)){
			Yii::app()->user->setFlash('error', 'We could not find a record of you wanting to change your password.  Please fill out the forgot password form again.');
			$this->redirect(array('//forgotpassword'));
		}

		$this->render('reset_password', array(
			'model' => $model
		));
	}

	public function actionResults()
	{
		$this->render('results', array(

		));
	}

	public function actionblah()
	{
		echo phpinfo();
	}
}
