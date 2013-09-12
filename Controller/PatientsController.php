<?php
App::uses('AppController', 'Controller');
/**
 * Patients Controller
 *
 * @property Patient $Patient
 */
class PatientsController extends AppController {

	public $autocomplete = true;
/**
 * index method
 *
 * @return void
 */
		
	public function index() {
		$this->Patient->recursive = 0;
		$this->set('patients', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Patient->id = $id;
		if (!$this->Patient->exists()) {
			throw new NotFoundException(__('Invalid patient'));
		}
		$this->set('patient', $this->Patient->read(null, $id));
	}

	
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Patient->create();
			if ($this->Patient->save($this->request->data)) {
				$this->Session->setFlash(__('The patient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The patient could not be saved. Please, try again.'));
			}
		}
		$events = $this->Patient->Event->find('list');
		$poisoningTypes = $this->Patient->PoisoningType->find('list');
		$poisoningRoutes = $this->Patient->PoisoningRoute->find('list');
		$poisoningPlaces = $this->Patient->PoisoningPlace->find('list');
		$poisoningCauses = $this->Patient->PoisoningCause->find('list');
		$evaluations = $this->Patient->Evaluation->find('list');
		$this->set(compact('events', 'poisoningTypes', 'poisoningRoutes', 'poisoningPlaces', 'poisoningCauses', 'evaluations'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Patient->id = $id;
		if (!$this->Patient->exists()) {
			throw new NotFoundException(__('Invalid patient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Patient->save($this->request->data)) {
				$this->Session->setFlash(__('The patient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The patient could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Patient->read(null, $id);
		}
		$events = $this->Patient->Event->find('list');
		$poisoningTypes = $this->Patient->PoisoningType->find('list');
		$poisoningRoutes = $this->Patient->PoisoningRoute->find('list');
		$poisoningPlaces = $this->Patient->PoisoningPlace->find('list');
		$poisoningCauses = $this->Patient->PoisoningCause->find('list');
		$evaluations = $this->Patient->Evaluation->find('list');
		$this->set(compact('events', 'poisoningTypes', 'poisoningRoutes', 'poisoningPlaces', 'poisoningCauses', 'evaluations'));
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
		$this->Patient->id = $id;
		if (!$this->Patient->exists()) {
			throw new NotFoundException(__('Invalid patient'));
		}
		if ($this->Patient->delete()) {
			$this->Session->setFlash(__('Patient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Patient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
