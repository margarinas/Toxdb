<?php
App::uses('AppController', 'Controller');
/**
 * Agents Controller
 *
 * @property Agent $Agent
 */
class AgentsController extends AppController {

	public $uses = array('Agent','Unit');
	public $paginate = array('Agent');
	public $autocomplete = true;

	public function index() {

		
		if(isset($this->request->data['term']))
			$term = $this->request->data['term'];
		elseif(isset($this->request->query['term']))
			$term = $this->request->query['term'];


		$conditions = array();
		if(!empty($term)) {
			$conditions = array(
				'Agent.name LIKE' => '%'.$term.'%'
				);
		}
		if($this->Auth->user('Group.name') != 'admin') {
			$conditions['OR']['Agent.default']=true;
			$conditions['OR']['Agent.user_id']=$this->Auth->user('id');
		}

		if($this->request->is('ajax'))
			$this->paginate['Agent']['limit']=7;

		$this->paginate['Agent']['order']='default ASC, Agent.name ASC';
		$this->paginate['Agent']['contain']=array('PoisonGroup','Substance');
		$this->set('agents', $this->paginate('Agent',$conditions));
		$this->set('units', $this->Unit->find('list',array('fields'=>array('id','name','group'))));
	}

	public function listAgents()
	{	
		$jsonAgent = array();
		//$agents = $this->Agent->find('all',array('recursive'=>-1));
		$agents = $this->Agent->find('all',array('recursive'=>-1,
			'conditions'=>array(
				'name LIKE'=>'%'.$_GET['term'].'%'
				),
			'limit' =>20
			));
		foreach ($agents as $key => $agent) {
			$jsonAgent[$key]['label'] = $agent['Agent']['name'];
			$jsonAgent[$key]['value'] = $agent['Agent']['id'];
		}
		return new CakeResponse(array('body' => json_encode($jsonAgent)));
	}

	public function loadElement($name) 
	{
		$this->render('/Elements/agent/'.$name, 'ajax');
	}

	public function view($id=null)
	{
		$this->Agent->id = $id;

		if (!$this->Agent->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->Agent->contain(
			'Substance',
			'Unit',
			'Treatment',
			'PoisonGroup'
			);
		$this->set('agent', $this->Agent->read(null, $id));
		
	}

	public function add()
	{


		if ($this->request->is('post')) {
			$this->request->data['Agent']['user_id'] = $this->Auth->user('id');
			$this->Agent->create();
			if(isset($this->request->data['Agent']['poison_subgroup_id']))
				$this->set('poison_subgroups', $this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$this->request->data['Agent']['poison_group_id']))));
			
			
			if($this->Agent->saveAll($this->request->data)) {
				$this->Session->setFlash(__('Įrašas išsaugotas'),'success');
				
				if($this->RequestHandler->isAjax()) {
					$this->set('units',$this->Unit->find('list',array('id','name','group')));
					$savedAgents = array();
					$this->request->data['Agent']['id'] = $this->Agent->id;
					$savedAgents[0]['Agent'] = $this->request->data['Agent'];
					$this->set('savedAgents',$savedAgents);

					

					$this->render('/Substances/dashboard');
				}
				 else
					$this->redirect(array('action' => 'index'));


			} else {
				$this->Session->setFlash('Negalėjome išsaugoti irašo bandykite dar kartą','failure');
			}
		}

		$this->set('units', $this->Unit->find('list',array('fields'=>array('id','name','group'))));
		$this->set('poison_groups', $this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null),'order'=>'PoisonGroup.order ASC')));
	}

	public function findSubgroups()	{
		$subgroups = array();
		if(isset($this->request->data['Agent'])) {
			$keys = array_keys($this->request->data['Agent']);
			if(is_numeric($keys[0]))
				$this->request->data['Agent'] = array_shift($this->request->data['Agent']);

			$model = 'Agent';
		} else if(isset($this->request->data['Substance'])) {
			$model = 'Substance';
		}
		
		if(!empty($this->request->data[$model]['poison_group_id'])) {
			$subgroups = $this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$this->data[$model]['poison_group_id'])));
		}
		
		$this->set('subgroups',$subgroups);
	}

	public function edit($id = null)
	{
		$this->Agent->id = $id;
		if (!$this->Agent->exists()) {
			throw new NotFoundException(__('Invalid agent'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			
			if($this->Agent->saveAll($this->request->data)) {
				$this->Session->setFlash(__('Įrašas išsaugotas'),'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Agent->read(null,$id);

		}
		$this->set('units', $this->Unit->find('list',array('fields'=>array('id','name','group'))));
		//pr($this->request->data);
		
		$this->set('poison_groups', $this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null),'order'=>'PoisonGroup.order ASC')));

		if(isset($this->request->data['Agent']['poison_subgroup_id']))
			$this->set('poison_subgroups', $this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$this->request->data['Agent']['poison_group_id']))));

		$this->render('add');
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Agent->id = $id;
		if (!$this->Agent->exists()) {
			throw new NotFoundException(__('Invalid Agent'));
		}

		$agent = $this->Agent->read(array('default','user_id'));
		if(!$agent['Agent']['default'] && $agent['Agent']['user_id'] == $this->Auth->user('id') || $this->Auth->user('Group.name')=='admin') {
			if ($this->Agent->delete()) {
				$this->Session->setFlash('Nuodinga medžiaga ištrinta','success');
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Nuodinga medžiaga nebuvo ištrinta'),'failure');
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('Neturite privilegijų ištrinti šią medžiagą'),'failure');
			$this->redirect(array('action' => 'index'));
		}

		
	}

	// public function find($needle)
	// {
	// 	$jsonResponse = array();
	// 	if(preg_match('/substance_/', $needle)) {
	// 		$needle = str_replace('substance_','',$needle);
	// 		$substances = $this->Agent->Substance->find('all',array('recursive'=>1,
	// 			'conditions'=>array(
	// 				$needle.' LIKE'=>'%'.$_GET['term'].'%'
	// 				),
	// 			'limit' =>20
	// 			));
	// 		foreach ($substances as $key => $substance) {
	// 			$jsonResponse[$key]['label'] = $substance['Substance'][$needle];
	// 			$jsonResponse[$key]['value'] = $substance['Agent'][0]['id'];
	// 		}
	// 	} else {

	// 		$agents = $this->Agent->find('all',array('recursive'=>-1,
	// 			'conditions'=>array(
	// 				$needle.' LIKE'=>'%'.$_GET['term'].'%'
	// 				),
	// 			'limit' =>20
	// 			));
	// 		foreach ($agents as $key => $agent) {
	// 			$jsonResponse[$key]['label'] = $agent['Agent'][$needle];
	// 			$jsonResponse[$key]['value'] = $agent['Agent']['id'];
	// 		}
	// 	}
	// 	return new CakeResponse(array('body' => json_encode($jsonResponse)));
	// }


}
