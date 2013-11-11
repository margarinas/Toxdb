<?php
App::uses('AppController', 'Controller');
/**
 * Antidotes Controller
 *
 * @property Antidote $Antidote
 */
class AntidotesController extends AppController {

/**
 * index method
 *
 * @return void
 */public $paginate = array('Antidote');
	public $autocomplete = true;

	public function index($term=null) {
		
		if(!empty($this->request->query['limit']))
			$this->paginate['Antidote']['limit']=$this->request->query['limit'];
		else if($this->request->is('ajax'))
			$this->paginate['Antidote']['limit']=25;

		$conditions = array();
		if(!empty($term)) {
			$conditions = array('name LIKE' => '%'.$term.'%');
		}

		$this->paginate['Antidote']['order'] = 'name';
		$this->set('antidotes', $this->paginate('Antidote',$conditions));
		$this->set('units', $this->Antidote->Unit->find('list',array('fields'=>array('id','name','group'))));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Antidote->id = $id;
		if (!$this->Antidote->exists()) {
			throw new NotFoundException(__('Invalid %s', __('antidote')));
		}
		$this->Antidote->contain('Unit','AgentsAntidote.Agent');
		$this->set('antidote', $this->Antidote->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Antidote->create();
			if ($this->Antidote->saveAll($this->request->data)) {
				$this->Session->setFlash('Antidotas išsaugotas','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Negalėjome išsaugoti irašo bandykite dar kartą','failure');
			}
		}
		$treatments = $this->Antidote->Treatment->find('list');
		$units = $this->Antidote->Unit->find('list',array('conditions'=>array('group'=>'conc')));
		$this->set(compact('treatments','units'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Antidote->id = $id;
		if (!$this->Antidote->exists()) {
			throw new NotFoundException(__('Invalid %s', __('antidote')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Antidote->save($this->request->data)) {
				$this->Session->setFlash('Antidotas išsaugotas','success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Negalėjome išsaugoti irašo bandykite dar kartą','failure');
			}
		} else {
			$this->request->data = $this->Antidote->read(null, $id);
		}
		$treatments = $this->Antidote->Treatment->find('list');
		$units = $this->Antidote->Unit->find('list',array('conditions'=>array('group'=>'conc')));
		$this->set(compact('treatments','units'));
		$this->render('add');

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
	$this->Antidote->id = $id;
	if (!$this->Antidote->exists()) {
		throw new NotFoundException(__('Invalid %s', __('antidote')));
	}
	
	if($this->Auth->user('Group.name')=='admin') {
		if ($this->Antidote->delete()) {
			$this->Session->setFlash('Nuodinga medžiaga ištrinta','success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Nuodinga medžiaga nebuvo ištrinta'),'failure');
		$this->redirect(array('action' => 'index'));
	} else {
		$this->Session->setFlash(__('Neturite privilegijų ištrinti šį priešnuodį'),'failure');
		$this->redirect(array('action' => 'index'));
	}
}
}