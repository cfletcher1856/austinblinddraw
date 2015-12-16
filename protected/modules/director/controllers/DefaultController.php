<?php

class DefaultController extends DirectorController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
