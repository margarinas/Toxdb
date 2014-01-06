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
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('Session','RequestHandler',
		'Auth' => array(
			'authError'=>'Neleistinas veiksmas'
			)
		);
	
	public $helpers = array(
        'Session',
        'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
        'Menu',
        'Form'=> array('className' => 'TwitterBootstrap.BootstrapForm'),
        'OldForm'=> array('className' => 'Form'),
        'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
    );


    // public function autocomplete($needle = '')
    // {
    // 	if(!$needle) {
    // 		throw new BadRequestException('You should enter a needle');
    		
    // 	} else if (!$this->autocomplete){
    // 		throw new MethodNotAllowedException('You can not use this method in this controller');
    // 	}
    // 	$results = $this->{$this->modelClass}->autocomplete($needle,$_GET['term']);
    // 	return new CakeResponse(array('body' => json_encode($results)));
    // }

    public function autocomplete($needle = '')
    {
        if(!$needle) {
            throw new BadRequestException('You should enter a needle');
            
        } else if (!$this->autocomplete){
            throw new MethodNotAllowedException('You can not use this method in this controller');
        }
        $results = $this->{$this->modelClass}->autocomplete($needle);
        return new CakeResponse(array('body' => json_encode($results)));
    }

    public function getElement()
    {
        if(!empty($this->request->query['name'])) {
            foreach ($this->request->query as $name => $query) {
                $this->set($name,$query);
            }
            $this->render('/Elements/'.$this->request->query['name']);
        }
    }

    public function beforeRender()
    {
        
        if(!empty($this->request->data['query']) && empty($this->request->query)) {
            $this->request->query = $this->request->data['query'];

        }
        // pr($this->request->query);
    }

}
