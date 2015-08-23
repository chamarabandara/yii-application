<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
	//'theme'=>'kongoon',
	'aliases' => array(
	'bootstrap' => realpath(__DIR__  . '/../extensions/bootstrap'), // change this if necessary
	),
	
		// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		//'application.extensions.bootstrap.helpers.*',
		//'bootstrap.helpers.TbHtml',
		'application.models.*',
		'application.components.*',
		'application.modules.*',
		'application.modules.users.models.Users',
		'application.modules.rights.*',
        'application.modules.rights.components.*',
         'application.extensions.bootstrap.*',
         'application.extensions.bootstrap.components.*',
          'application.extensions.bootstrap.behaviours.*',
          'application.extensions.bootstrap.helpers.*',
          'application.extensions.bootstrap.widgets.*',
          'application.extensions.bootstrap.helpers.TbHtml',
           'application.extensions.bootstrap.behaviors.TbWidget',
	),
	

	'modules'=>array(
		// uncomment the following to enable the Gii tool
 		'users'=>array(
 				//'tableUsers' => 'user',
               // 'tableProfiles' => 'profiles',
               // 'tableProfileFields' => 'profiles_fields',

 			),
 		 'cources',
 		'rights'=>array(
 		 'superuserName'=>'adminstrator', // Name of the role with super user privileges. 
 		'authenticatedName'=>'Authenticated', // Name of the authenticated user role. 
 		'userIdColumn'=>'id', // Name of the user id column in the database.
 		 'userNameColumn'=>'username', // Name of the user name column in the database.
 		//  'enableBizRule'=>true, // Whether to enable authorization item business rules.
 		  // 'enableBizRuleData'=>false, // Whether to enable data for business rules. 
 		  // 'displayDescription'=>true, // Whether to use item description instead of name. 
 		 //  'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages.
 		  //  'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages.
 		   //  'install'=>false, // Whether to install rights. 'baseUrl'=>'/rights',
 		      // Base URL for Rights. Change if module is nested. 
 		    //  'layout'=>'rights.views.layouts.main', // Layout to use for displaying Rights. 
 		    //  'appLayout'=>'application.views.layouts.main', // Application layout. 
 		    //  'cssFile'=>'rights.css', // Style sheet file to use for Rights.
 		       'install'=>false, // Whether to enable installer. 
 		       'debug'=>false, // Whether to enable debug mode.
 		        ),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(

		'user'=>array(
			'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'bootstrap' => array(
			 'cdnUrl'=>"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/",
        'class' => 'application.extensions.bootstrap.components.TbApi',   
    ),

		'authManager'=>array(
                'class'=>'RDbAuthManager',
              //  'connectionID'=>'db',
               // 'defaultRoles'=>array('Authenticated', 'Guest'),
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

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
	'params'=>require(dirname(__FILE__).'/params.php'),
	
);
