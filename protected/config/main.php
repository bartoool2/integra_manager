<?php

Yii::setPathOfAlias('matwork', dirname(__FILE__).'/../../matwork');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Integra Manager',
	'theme'=>'default',
	// preloading 'log' component
	'preload'=>array('log'),
	'language' => 'pl',

	// autoloading model and component classes
	'import'=>array(
//		'matwork.components.*',
//		'matwork.behaviors.*',
//		'matwork.filters.*',
//		'matwork.forms.*',
//		'matwork.helpers.*',
//		'matwork.helpers.PHPExcel.*',
//		'matwork.helpers.PHPExcel.Shared.*',
//		'matwork.helpers.PHPExcel.Reader.*',
//		'matwork.helpers.PHPExcel.Reader.Excel2007.*',
//		'matwork.helpers.PHPExcel.Writer.*',
//		'matwork.helpers.PHPExcel.Writer.Excel2007.*',
//		'matwork.helpers.PHPExcel.Calculation.*',
//		'matwork.helpers.PHPExcel.CachedObjectStorage.*',
//		'matwork.helpers.PHPExcel.CalcEngine.*',
//		'matwork.helpers.PHPExcel.Cell.*',
//		'matwork.helpers.PHPExcel.RichText.*',
//		'matwork.helpers.PHPExcel.Style.*',
//		'matwork.helpers.PHPExcel.Worksheet.*',
//		'matwork.helpers.ZipStream.*',
//		'matwork.validators.*',
		'application.forms.*',
		'application.templates.*',
		'application.models.*',
		'application.components.*',
		'application.formats.*',
		'application.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			'class'=>'WebUser',
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'curl' =>array(
			'class' => 'application.extensions.curl.Curl',
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
//		'db'=>array(
//			'connectionString' => 'mysql:host=localhost;dbname=integra_manager',
//			'emulatePrepare' => true,
//			'username' => 'root',
//			'password' => '',
//			'charset' => 'utf8',
//		),
		'db'=>array(
			'connectionString' => 'mysql:host=s6.jupe.pl;dbname=bstokro_intrs',
			'emulatePrepare' => true,
			'username' => 'bstokro',
			'password' => 'KyuG73QK',
			'charset' => 'utf8',
		),
		'message'=>array(
			'class'=>'matwork.plugins.message.ZMessage',
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
		'adminEmail'=>'webmaster@example.com',
	),
);