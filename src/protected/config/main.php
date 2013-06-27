<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'XBMC Video Server',
	'defaultController'=>'movie',

	// preloaded components. Uncomment "less" in order to compile the LESS 
	// files on the fly (requires node.js and lessc)
	'preload'=>array(
		'log', 
		//'less'
	),
	
	'aliases'=>array(
		'bootstrap'=>realpath(__DIR__.'/../../../vendor/crisu83/yiistrap'),
		'composer'=>realpath(__DIR__.'/../../../vendor'),
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
		'application.widgets.*',
		'bootstrap.helpers.TbHtml',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'bootstrap'=>array(
			'class'=>'bootstrap.components.TbApi',
		),
		'clientScript'=>array(
			'packages'=>array(
				'jquery'=>array(
					'baseUrl'=>'//ajax.googleapis.com/ajax/libs/jquery/1.9.1/',
					'js'=>array(YII_DEBUG ? 'jquery.min.js' : 'jquery.js'),
				),
				'bbq'=>array('js'=>false),
			),
		),
		'config'=>array(
			'class'=>'Settings', // there's a model called Config already
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.__DIR__.'/../data/xbmc-video-server.db',
		),
		'xbmc'=>array(
			'class'=>'XBMC',
		),
		'less'=>array(
			'class'=>'composer.jalle19.yii-less.components.LessServerCompiler',
			'files'=>array(
				'css/less/styles.less'=>'css/styles.css',
				'css/less/login.less'=>'css/login.css',
			),
			// LessServerCompiler-specific settings
			'nodePath'=>'/usr/local/bin/node',
			'compilerPath'=>'/usr/local/bin/lessc',
			'strictImports'=>false,
			'compression'=>false,
			'optimizationLevel'=>2,
			'forceCompile'=>false,
		),
		'user'=>array(
			'class'=>'WebUser',
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

);