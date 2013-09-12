<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */

public $uses = array('User','Cms.Post');
public $scaffold;
public $autocomplete = true;

function beforeFilter () {
	$this->Auth->allow('login','logout');
}


public function login()
{	
	if ($this->request->is('post')) {
		if ($this->Auth->login()) {
			$this->User->id = $this->Auth->user('id');
			$this->User->save(array('last_login'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER["REMOTE_ADDR"]));

			return $this->redirect(array('action'=>'login_other_db'));
		} else {
			$this->Session->setFlash(__('Vartotojo vardas arba slaptažodis neteisingas'), 'failure', array(), 'auth');
		}
	}
}

public function logout()
{
	$this->redirect($this->Auth->logout());
}

public function dashboard() {
	if(!$this->request->is('ajax'))
		$this->layout = 'user';
	$user = $this->User->find('first',array(
		'conditions'=>array('User.id'=>$this->Auth->user('id'))
		));
	//pr($data);
	$posts = $this->Post->find('all',array(
	'order'=>'created DESC',
	'limit' => 2
		)
	);

	// $this->paginate = array('Event' => array(
	// 	'order' => 'Event.created DESC',
	// 	'contain' => array(
	// 		'Patient' => array(
	// 			'fields'=>array('Patient.name','Patient.id'),
	// 			'AgentsPatient' => array('Agent'=>array('fields'=>array('id','name'))),
	// 			'Substance' => array('fields'=>array('name','id'))
	// 			),
	// 		'User'=>array('fields'=>array('id','name'))
	// 		),
	// 	'conditions'=>array(
	// 		'Event.created >='=>date('Y-m-d H:i:s',strtotime('-1 week')),
	// 		'Event.user_id' => $this->Auth->user('id')
	// 		),
	// 	)
	// );

	// $this->set('drafts',$this->paginate('Draft'));
	$this->set('user',$user);
	$this->set('posts',$posts);
	// $this->set('events',$this->paginate('Event'));
}

public function login_other_db()
{
	
}

}
