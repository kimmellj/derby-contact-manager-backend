<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    var $components = array(
        'Session',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'contacts',
                'action' => 'login'
            )
        )
    );
    public $loggedIn = false;

    public function beforeFilter()
    {
        Configure::load('facebook', 'default');
        App::import('Vendor', 'facebook-php-sdk/src/facebook');
        $this->Facebook = new Facebook(array(
            'appId'     =>  Configure::read('Facebook.appId'),
            'secret'    =>  Configure::read('Facebook.secret')
        ));

        $this->Auth->authenticate = array(
            AuthComponent::ALL => array('userModel' => 'Contact')
        );
    }

    public function beforeRender() {
        $this->set('fb_login_url', $this->Facebook->getLoginUrl(array('redirect_uri' => Router::url(array('controller' => 'contacts', 'action' => 'login'), true))));
        $this->set('user', $this->Auth->user());
    }
}
