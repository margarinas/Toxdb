<?php
App::uses('AppController', 'Controller');
/**
 * Drafts Controller
 *
 * @property Draft $Draft
 */
class DraftsController extends AppController {

	public function index($model = null) {

		if(!empty($this->request->query['limit']))
			$limit=$this->request->query['limit'];
		else
			$limit=3;

		$this->paginate = array(
			'conditions'=> array('model'=>$model,'user_id'=>$this->Auth->user('id')),
			'limit' => $limit
			);

		$this->set('drafts',$this->paginate());

	}

	public function delete() {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$this->Draft->id = $this->request->query['id'];
		if (!$this->Draft->exists()) {
			throw new NotFoundException(__('Invalid draft'));
		}
		if ($this->Draft->delete()) {
			$message = "Juodraštis ištrintas";
			$result = "success";
		} else {
			$message = "Juodraščio ištrinti nepavyko";
			$result = "failed";
		}

		$this->set(compact('message','result'));
		$this->set('_serialize',array('message','result'));
	}



}
