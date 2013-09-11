<?php
App::uses('AppController', 'Controller');
/**
 * Calls Controller
 *
 * @property Call $Call
 */
class CallsController extends AppController {

	public $paginate = array('Call');
/**
 * index method
 *
 * @return void
 */
public $layout = 'user';

public function beforeFilter() {
	$this->Auth->allow('getCalls');
}

public function index() {
	$this->Call->recursive = 0;
	if($this->request->is('ajax'))
		$this->paginate['Call']['limit']=7;

	$this->paginate['Call']['order'] = 'Call.created DESC';
	$this->set('calls', $this->paginate('Call'));
}

public function getCalls() {

	if($this->Call->importCalls())
		$this->redirect(array('action' => 'index'));
}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
public function view($id = null) {
	$this->Call->id = $id;
	if (!$this->Call->exists()) {
		throw new NotFoundException(__('Invalid %s', __('call')));
	}
	$this->set('call', $this->Call->read(null, $id));
}

/**
 * add method
 *
 * @return void
 */
public function add() {
	if ($this->request->is('post')) {
		$this->Call->create();
		if ($this->Call->save($this->request->data)) {
			$this->Session->setFlash(
				__('The %s has been saved', __('call')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
					)
				);
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(
				__('The %s could not be saved. Please, try again.', __('call')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
					)
				);
		}
	}
	$events = $this->Call->Event->find('list');
	$this->set(compact('events'));
}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
public function edit($id = null) {
	$this->Call->id = $id;
	if (!$this->Call->exists()) {
		throw new NotFoundException(__('Invalid %s', __('call')));
	}
	if ($this->request->is('post') || $this->request->is('put')) {
		if ($this->Call->save($this->request->data)) {
			$this->Session->setFlash(
				__('The %s has been saved', __('call')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-success'
					)
				);
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(
				__('The %s could not be saved. Please, try again.', __('call')),
				'alert',
				array(
					'plugin' => 'TwitterBootstrap',
					'class' => 'alert-error'
					)
				);
		}
	} else {
		$this->request->data = $this->Call->read(null, $id);
	}
	$events = $this->Call->Event->find('list');
	$this->set(compact('events'));
}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
public function delete($id = null) {
	if (!$this->request->is('post')) {
		throw new MethodNotAllowedException();
	}
	$this->Call->id = $id;
	if (!$this->Call->exists()) {
		throw new NotFoundException(__('Invalid %s', __('call')));
	}
	if ($this->Call->delete()) {
		$this->Session->setFlash(__('Sėkmingai ištrintas'),'success');
		$this->redirect(array('action' => 'index'));
	}
	$this->Session->setFlash(__('Ištrinti nepavyko'),'failure');
	$this->redirect(array('action' => 'index'));
}

public function removeEvent($id = null) {
	if (!$this->request->is('post')) {
		throw new MethodNotAllowedException();
	}
	//$this->render(false);
	$this->Call->id = $id;
	if (!$this->Call->exists()) {
		throw new NotFoundException(__('Invalid %s', __('call')));
	}
	if ($this->Call->saveField('event_id','',false)) {
		return new CakeResponse(array('type'=>'json','body' => json_encode(array('success'=>true,'type'=>$this->request->is('post')))));
	}
	return new CakeResponse(array('body' => json_encode(array('success'=>false))));
}
}
