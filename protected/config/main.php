<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Raggedy Anne\'s Blind Draw',
	'theme'=>'raggedy_anne',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.phpmailer.JPhpMailer',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'jollyrancher',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array($_SERVER['REMOTE_ADDR']),
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),
		'admin',
		'director',
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'application.components.EWebUser',
      		'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'showScriptName' => false,
			'urlFormat'=>'path',
			'rules'=>array(
				'login' => 'site/login',
				'blah' => 'site/blah',
				'bracket' => 'site/bracket',
				'forgotpassword' => 'site/forgotpassword',
				'resetpassword/<uuid:\w+>' => 'site/resetpassword',
				'results' => 'site/results',
				'contact' => 'site/contact',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=colinfle_ragsblinddraw',
			'emulatePrepare' => true,
			'username' => 'colinfle_rags',
			'password' => 'd[Pdr){Ds-,M',
			'charset' => 'utf8',
			'tablePrefix' => '',
			'enableParamLogging' => true,
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					'logPath' => '/home4/colinfle/www/ragsblinddraw.com/logs',
					'logFile' => date('Ymd') . '.log',
				),
				// uncomment the following to show log messages on web pages
				// array(
				// 	'class'=>'CWebLogRoute',
				// ),
			),
		),
		'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
        'less' => array(
			'class'=>'ext.less.components.Less',
			'mode'=>'server',
			'files'=>array(
				'less/styles.less' => 'css/styles.css',
			),
			'options'=>array(
				'nodePath'=>'/home4/colinfle/node/bin/node',
				'compilerPath'=>'/home4/colinfle/node/bin/lessc',
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'cfletcher1856@gmail.com',
		'challonge_api' => '5xaZh0amyz6D2yWYftpQNg8c2wSxl64Tu7dK8yYG'
	),
);
