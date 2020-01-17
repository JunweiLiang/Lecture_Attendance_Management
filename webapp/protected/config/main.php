<?php

// uncomment the following to define a path alias
 Yii::setPathOfAlias('bootstrap','protected/extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Lecture CheckIn by Junwei Liang',
	'theme'=>'basic',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(

	),
	'defaultController' => 'checkIn/index',
	// application components
	'components'=>array(
		'bootstrap' => array(
			'class' => 'bootstrap.components.Bootstrap'
		),
		'request'=>array(
            'enableCookieValidation'=>true,
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
		//	'showScriptName'=>false,    // 这一步是将代码里链接的index.php隐藏掉。
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),



		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=LectureAttendanceApp',
			'emulatePrepare' => true,
			'username' => 'lectureAttDBUser',
			'password' => 'mysqlpassword',
			'charset' => 'utf8',
		),


		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'checkIn/error',
		),
		/*
		//未安装memcache扩展，退而求其次，使用file缓存
		'cache'=>array(
            'class'=>'system.caching.CMemCache',
            'servers'=>array(
                array('host'=>'server1', 'port'=>11211, 'weight'=>60),
                array('host'=>'server2', 'port'=>11211, 'weight'=>40),
            ),
        ),
        */
        'cache' => array (
			'class' => 'system.caching.CFileCache',
        	'directoryLevel' => 2,
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'junweil@cs.cmu.edu',
	),
);
