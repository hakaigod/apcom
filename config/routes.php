<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope("/student", function ( RouteBuilder $routes ) {
	
	$routes->connect(
		'/:id',
		['controller' => 'student', 'action'=> 'summary'],
//		 8桁の数字に制限、0始まりに対応
		['id' => '\d{8}']
	);
	
	$routes->connect(
		'/updatePassword',
		['controller' => 'student', 'action'=> 'updatePass']
	);
	$routes->connect(
		'/input/:imicode/:linkNum',
		['controller' => 'student', 'action'=> 'input'],
		['id' => '\d{8}','imicode' => '\d{1,3}', 'linkNum' => '[1-8]{1}']
	);
	$routes->connect(
		'/sendAll/:imicode/',
		['controller' => 'student', 'action'=> 'sendAll'],
		['id' => '\d{8}','imicode' => '\d{1,3}']
	);
	$routes->connect(
		'/result/:id/:imicode',
		['controller' => 'student', 'action'=> 'result'],
		['id' => '\d{8}','imicode' => '\d{1,3}']
	);
	$routes->connect(
		'/qaaSelectGenre',
		['controller' => 'student', 'action' => 'qaaSelectGenre']
	);

    $routes->connect(
        '/qaaAlert',
        ['controller' => 'student', 'action' => 'qaaAlert']
    );

    $routes->connect(
        '/qaaResult/:pagination_num/',
        ['controller' => 'student', 'action' => 'qaaResult'],
        ['pagination_num' => '\d+',]
    );

	$routes->connect(
		'/qaaQuestion/:question_num/',
		['controller' => 'student', 'action' => 'qaaQuestion'],
		['question_num' => '\d+',]
	);
	
	$routes->connect(
		'/yearSelection',
		['controller' => 'student', 'action' => 'yearSelection']
	);
	
	$routes->connect(
		'/practiceExam/:exanum/:qesnum/',
		['controller' => 'student', 'action' => 'practiceExam'],
		['exanum' => '\d{1,3}','qesnum'=>'\d{1,2}']
	);
	
	$routes->connect(
		'/score/:exanum/',
		['controller' => 'student', 'action' => 'score'],
		['exanum' => '\d{1,3}']
	);
	
});
Router::scope("/manager", function ( RouteBuilder $routes ) {
	$routes->connect(
		'',
		['controller' => 'manager', 'action'=> 'index']);
	$routes->connect(
		'/imitation/register',
		['controller' => 'manager', 'action'=> 'imiCodeIssue']);
});
//学生、学科、管理者の管理
Router::scope("/manager/maintenance", function ( RouteBuilder $routes ) {
	//学生管理
	$routes->connect(
		'/students',
		['controller' => 'manager', 'action' => 'stuManager']
	);
	$routes->connect(
		'/students/add',
		['controller' => 'manager', 'action' => 'addstu']
	);
	$routes->connect(
		'/students/modify',
		['controller' => 'manager', 'action' => 'modstu']
	);
	$routes->connect(
		'/students/reset',
		['controller' => 'manager', 'action' => 'reIssueStuPass']
	);
	//学科管理
	$routes->connect(
		'/departments',
		['controller' => 'manager', 'action' => 'depManager']
	);
	$routes->connect(
		'/departments/add',
		['controller' => 'manager', 'action' => 'adddep']
	);
	$routes->connect(
		'/departments/mod',
		['controller' => 'manager', 'action' => 'moddep']
	);
	//管理者管理
	$routes->connect(
		'/admins',
		['controller' => 'manager', 'action' => 'adminManager']
	);
	$routes->connect(
		'/admins/add',
		['controller' => 'manager', 'action' => 'addadmin']
	);
	$routes->connect(
		'/admins/mod',
		['controller' => 'manager', 'action' => 'modadmin']
	);
	$routes->connect(
		'/admins/reset',
		['controller' => 'manager', 'action' => 'resetAdmPass']
	);
	$routes->connect(
		'/question_detail',
		['controller' => 'manager', 'action' => 'question_detail']
	);
});


Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
	$routes->connect('', ['controller' => 'Login', 'action' => 'index']);
	$routes->connect('login', ['controller' => 'Login', 'action' => 'index']);
	
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
//    $routes->fallbacks(DashedRoute::class);
});

// Router::connect('*', array('controller' => 'error', 'action' => 'beforeRender'));
/**

 * Load all plugin routes. See the Plugin documentation on
>>>>>>> 06f60cc757dd0b5aa0de321dad87b35ae62b5ec7
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
