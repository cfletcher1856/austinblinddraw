<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
			'ext.phpmailer.JPhpMailer',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			if(Yii::app()->user->isGuest){
				Controller::redirect(Controller::createUrl(Yii::app()->user->loginUrl[0]));
			}
			if(!Yii::app()->user->isAdmin()){
				throw new CHttpException(403,'You are not authorized to perform this action.');
			}
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
