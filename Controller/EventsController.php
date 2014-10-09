<?php
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 */
class EventsController extends AppController {

	public $uses = array('Event','PatientAttribute','Agent','Antidote','Evaluation','Substance','Unit');
	public $components = array('Search.Prg');
	public $presetVars = true;
	public $autocomplete = true;
/**
 * index method
 *
 * @return void
 */


public function index() {



	if(!empty($this->request->query['limit']))
		$limit=$this->request->query['limit'];
	else
		$limit = 20;

	$this->paginate = array(
		'limit'=>$limit,
		'order' => 'Event.created DESC',
		'contain'=>array(
			'User' => array('fields'=>array('id','name')),
			'Substance' => array('fields'=>array('id','name')),
			'Agent' => array('fields'=>array('id','name')),
			'Patient' => array(
				'fields'=>array('name','id'),
				'Substance',
				'AgentsPatient' => array('Agent')
				)
			),
		'conditions' => array('Event.created >'=>date('Y-m-d',strtotime('-1 week')))
		);


	// $events = $this->paginate();
	$events = array();

	$showSearch = (!empty($this->data['Event']) || empty($events))?'in':false;
	$this->set('showSearch',$showSearch);
	$this->set('events', $events);


	$eventTypes =  $this->Event->getEventTypes();
	$this->set('eventType',$eventTypes['main']);
	$this->set('poison_group',$this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null),'order'=>'PoisonGroup.order ASC')));

}

public function find()
{

	$this->Prg->commonProcess();
	$parsedParams = $this->Prg->parsedParams();

	if(!empty($this->params['named']['current_user']))
		$parsedParams['user_id']=$this->Auth->user('id');

	$limit = !empty($this->params['named']['event_per_page'])?$this->params['named']['event_per_page']:20;

	$this->request->data['Event']['event_per_page'] = $limit;

	$joins = array(
		array(
				'table'=>'patients', 
				'alias' => 'Patient',
				'type'=>'left',
				'conditions'=> array(
					'Patient.event_id = Event.id'
				))	
		);

	if(!empty($parsedParams['poison']) || !empty($parsedParams['substance_id']) || !empty($parsedParams['agent_id'])) {
		$poison_joins = array(
		 	array(
				'table'=>'agents_patients', 
				'alias' => 'AgentsPatient',
				'type'=>'left',
				'conditions'=> array(
					'Patient.id = AgentsPatient.patient_id'
				)),
			array(
				'table'=>'agents', 
				'alias' => 'Agent',
				'type'=>'left',
				'conditions'=> array(
					'Agent.id = AgentsPatient.agent_id'
				)),
			array(
				'table'=>'patients_substances', 
				'alias' => 'PatientsSubstance',
				'type'=>'left',
				'conditions'=> array(
					'Patient.id = PatientsSubstance.patient_id'
				)),
			array(
				'table'=>'substances', 
				'alias' => 'Substance',
				'type'=>'left',
				'conditions'=> array(
					'Substance.id = PatientsSubstance.substance_id'
				))
			);

		$joins= array_merge($joins,$poison_joins);
	}

	if(!empty($parsedParams['event_type'])) {
		$event_type_joins = array(
			array(
				'table'=>'events_event_attributes', 
				'alias' => 'EventsEventAttribute',
				'type'=>'left',
				'conditions'=> array(
					'EventsEventAttribute.event_id = Event.id'
					))
		);
		$joins= array_merge($joins,$event_type_joins);
	}

	$this->paginate = array(
		'order' => 'Event.created DESC',
		'contain' => array(
			'Substance' => array('fields'=>array('id','name')),
			'Agent' => array('fields'=>array('id','name')),
			'Patient' => array(
				'fields'=>array('Patient.name','Patient.id'),
				'AgentsPatient' => array('Agent'=>array('fields'=>array('id','name'))),
				'Substance' => array('fields'=>array('name','id')),
				),
			'User'=>array('fields'=>array('id','name'))
			),
		// 'fields'=>array('Event.id','Event.created','Patient.id','Patient.name','Agent.id','Agent.name','Substance.id','Substance.name','User.name','User.id'),
		'joins'=>$joins,
		'conditions' => $this->Event->parseCriteria($parsedParams),
		'limit' => $limit
		);


	//$this->request->data['Event'] += $this->passedArgs;


	$eventTypes = $this->Event->getEventTypes();

	if(!empty($this->params['named']['noSearchForm']))
		$this->set('noSearchForm',true);
	$this->set('showSearch','in');
	$this->set('eventType',$eventTypes['main']);
	$this->set('poison_group',$this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null),'order'=>'PoisonGroup.order ASC')));
	$this->set('events',$this->paginate());
	$this->render('index');
}


/**
 * view method
 *
 * @param string $id
 * @return void
 */
public function view($id = null) {
	$this->Event->id = $id;
	if (!$this->Event->exists()) {
		throw new NotFoundException(__('Invalid event'));
	}

	$event = $this->Event->findViewData($id);
	$this->set(compact('event'));
}

public function multiplePrint() {
	$events = array();
	// pr($this->data);
	if(!empty($this->data['Event'])) {
		foreach ($this->data['Event'] as $event_id) {
			$events[] = $this->Event->findViewData($event_id);
		}
		
	}
	$this->set('events',$events);
	$this->render('view');

}

/**
 * add method
 *
 * @return void
 */
public function add() {


	$this->set('title_for_layout', 'Naujas atvejis');

	if(!empty($this->request->query) && !$this->request->is('post')) {
		// pr($this->request->query);
		$this->request->data = Hash::expand($this->request->query,'$');
		// pr($this->request->data);
	}


	if ($this->request->is('post')) {

		// pr($this->request->data);

		if($this->Auth->user('Group.name') != 'admin')
			$this->request->data['Event']['user_id'] = $this->Auth->user('id');

		if(!empty($this->data['Patient'][0]['Substance'])) {
			$substances = $this->Substance->find('all',array('conditions'=>array('Substance.id'=>$this->data['Patient'][0]['Substance'])));
		}

		if(!empty($this->data['Patient'][0]['Agent'])) {
			$agents = $this->Agent->find('all',array('conditions'=>array('Agent.id'=>$this->data['Patient'][0]['Agent']),'recursive'=>-1));
		}

		if(!empty($this->data['Patient'][0]['Antidote'])) {
			$antidotes = $this->Antidote->find('all',array('conditions'=>array('Antidote.id'=>$this->data['Patient'][0]['Antidote']),'recursive'=>-1));
		}
		

		$this->Event->create();

    // didn't validate logic


		if ($this->Event->saveAll($this->request->data,array('deep'=>true))) {

			$this->Session->setFlash(__('Įrašas išsaugotas'),'success');
			if(Configure::read('debug')==0)
				$this->redirect(array('action' => 'view',$this->Event->id));

		} else {
			$this->Session->setFlash('Negalėjome išsaugoti irašo bandykite dar kartą','failure');
		}
	} else {
		if(empty($this->request->data['Event']['created']))
			$this->request->data['Event']['created'] = date('Y-m-d H:i');
	}


	$units = $this->Unit->groupList();
	$formLists = $this->Event->getFormLists();
	extract($formLists);
	//pr($eventTypes);
	$this->set(compact('units','substances','agents','antidotes',array_keys($formLists)));

}


/**
 * edit method
 *
 * @param string $id
 * @return void
 */
public function edit($id = null) {
	
	$this->Event->id = $id;
	
	if ($this->Event->field('user_id') != $this->Auth->user('id') && $this->Auth->user('Group.name') != 'admin') {
		$this->Session->setFlash('Neleistinas veiksmas','failure');
		$this->redirect('/events');
		exit;
	};

	$this->Event->contain(array(
		'Patient' => array(
			'AgentsPatient' => array('Agent'),
			'AntidotesPatient' => array('Antidote'),
			'PatientAttributeValue',
			'Substance',
			'Evaluation',
			'PoisoningAttribute'
			),
		'EventAttribute',
		'Call',
		'Substance',
		'Agent',
		'Draft'=>array('fields'=>array('id'))
		));



	if (!$this->Event->exists()) {
		throw new NotFoundException(__('Invalid event'));
	}

	

	if ($this->request->is('post') || $this->request->is('put')) {

		
		if(!empty($this->data['Patient'][0]['Substance'])) {
			$substances = $this->Substance->find('all',array('conditions'=>array('Substance.id'=>$this->data['Patient'][0]['Substance'])));
		} else if(!empty($this->data['Event']['Substance'])) {
			$substances = $this->Substance->find('all',array('conditions'=>array('Substance.id'=>$this->data['Event']['Substance'])));
			$substances = Hash::extract($substances, '{n}.Substance');
		}

		if(!empty($this->data['Patient'][0]['Agent'])) {
			$agents = $this->Agent->find('all',array('conditions'=>array('Agent.id'=>$this->data['Patient'][0]['Agent'])));
		} else if(!empty($this->data['Event']['Agent'])) {
			$agents = $this->Agent->find('all',array('conditions'=>array('Agent.id'=>$this->data['Event']['Agent'])));
			$agents = Hash::extract($agents, '{n}.Agent');
		}

		if(!empty($this->data['Patient'][0]['Antidote'])) {
			$antidotes = $this->Antidote->find('all',array('conditions'=>array('Antidote.id'=>$this->data['Patient'][0]['Antidote'])));
		}

		
		if ($this->Event->saveAll($this->request->data,array('deep'=>true,'saveAllFields'=>true))) {

			
			//$this->Agent->saveAll($this->request->data['Agent']);
			$this->Session->setFlash(__('Įrašas atnaujintas'),'success');
			if(Configure::read('debug')==0)
				$this->redirect(array('action' => 'index'));
		} else {
			pr($this->Event->validationErrors);
			$this->Session->setFlash(__('Įrašas negalėjo būti išsaugotas. Bandykite dar kartą'),'failure');
		}
	} else {
		$this->request->data = $this->Event->read(null,$id);

		// $this->Event->bindModel(array('hasOne' => array('EventRelation')));
		// $this->request->data['RelatedEvent']['RelatedEvent'] = array_values($this->Event->EventRelation->find('list',array('conditions'=>array('event_id'=>$id),'fields'=>array('event_id','related_event_id'))));

		if(!empty($this->request->data['Patient'])) {
			$patient_id = $this->request->data['Patient'][0]['id'];

			$selected_subgroup_attr = Hash::combine($this->request->data['Patient'][0]['PoisoningAttribute'],'{n}.subgroup','{n}.id','{n}.group');
			$selected_group_attr = Hash::combine($this->request->data['Patient'][0]['PoisoningAttribute'],'{n}.id','{n}.id','{n}.group');
		//visa tvarka tokia pat kaip išdėlioti laukai view.
			unset($this->request->data['Patient'][0]['PoisoningAttribute']);

			foreach ($selected_group_attr as $key => $group_attr) {
				if(in_array($key, array('p_cause'))) {
					$this->request->data['Patient'][0]['PoisoningAttribute'][$key] = $selected_subgroup_attr[$key];
				}
				else if(count($group_attr)>1)
					$this->request->data['Patient'][0]['PoisoningAttribute'][$key] = $group_attr;
				else
					$this->request->data['Patient'][0]['PoisoningAttribute'][$key] = array_shift($group_attr);
			}

			// $selected_eval = Hash::combine($this->request->data['Patient'][0]['Evaluation'],'{n}.id','{n}.id','{n}.group');
			// $eval_groups = array('symptoms','risk','grade','dose','final_grade');
			// foreach ($eval_groups as $key => $eval_group) {
			// 	$this->request->data['Patient'][0]['Evaluation'][$key]=!empty($selected_eval[$eval_group])?array_shift($selected_eval[$eval_group]):0;
			// }

			$selected_eval = Hash::combine($this->request->data['Patient'][0]['Evaluation'],'{n}.id','{n}.id','{n}.group');
			unset($this->request->data['Patient'][0]['Evaluation']);
			foreach ($selected_eval as $eval_group => $eval) {
				$this->request->data['Patient'][0]['Evaluation'][$eval_group]= array_shift($eval);
			}
			
			$substances = $this->request->data['Patient'][0]['Substance'];
			$agents =$this->request->data['Patient'][0]['AgentsPatient'];
			$antidotes =$this->request->data['Patient'][0]['AntidotesPatient'];

		} else {
			$substances = $this->data['Substance'];
			$agents =$this->data['Agent'];

			$this->request->data['Event']['no_patient'] = true;
		}
	}



	$units = $this->Unit->find('list',array('fields'=>array('id','name','group')));
	
	$formLists = $this->Event->getFormLists();
	extract($formLists);
	$this->set(compact('units','substances','agents','antidotes',array_keys($formLists)));
	$this->render('/Events/add');
}



/**
 * delete method
 *
 * @param string $id
 * @return void
 */
public function delete() {
	if (!$this->request->is('post')) {
		throw new MethodNotAllowedException();
	}
	$this->Event->id = $this->request->query['id'];
	if (!$this->Event->exists()) {
		throw new NotFoundException(__('Invalid draft'));
	}
	if ($this->Event->delete()) {
		$message = "Atvejis ištrintas";
		$result = "success";
	} else {
		$message = "Atvejo ištrinti nepavyko";
		$result = "failed";
	}

	$this->set(compact('message','result'));
	$this->set('_serialize',array('message','result'));
	
}

public function report() {
	if(!$this->request->is('ajax'))
		$this->layout = 'user';
	if($this->request->is('post')) {
		
		if(!empty($this->data['Event']['begin_date']) || !empty($this->data['Event']['end_date'])) {
			$report = $this->Event->report($this->data['Event']);
			$this->set('report',$report);
		} else {
			$this->Session->setFlash('Pasirinkite datą','failure');
		}
		
		
	}
}


public function asht_report() {
	
	$report = $this->Event->asht_report();

	 $this->response->body($report);
	 $this->response->charset('UTF-8');
    $this->response->type('xml');

    //Optionally force file download
    $this->response->download('import-lt-2014-01.xml');

    // Return response object to prevent controller from trying to render
    // a view
    return $this->response;
}

public function saveDraft() {



	if($this->request->is('post') || $this->request->is('put')) {

		$saveData = array(
			'model' => 'Event',
			'user_id' => $this->Auth->user('id'),
			'content' => $this->data,
			);

		
		if(!empty($this->data['Event']['id'])) {
			$saveData['assoc_id'] = $this->data['Event']['id'];
		}

		if(!empty($this->data['Draft']['id'])) {		
			$this->Event->Draft->id = $this->data['Draft']['id'];
		} else {
			$this->Event->Draft->create();
		}

		if($this->Event->Draft->save($saveData)) {
			$draft_id = $this->Event->Draft->id;
			
			if(empty($this->data['Draft']['id']))
				$result = 'created';
			else
				$result = 'saved';
		} else {
			$result = 'failed';
			$draft_id = false;
		}
		
		
	}

	$this->set('draft_id',$draft_id);
	$this->set('result',$result);
	$this->set('_serialize',array('draft_id','result'));
}

public function restoreDraft($id = null) {

	$this->Event->Draft->id = $id;
	if (!$this->Event->Draft->exists()) {
		throw new NotFoundException(__('Invalid draft'));
	}
	$draft = $this->Event->Draft->read(null,$id);
	if(!$this->request->is('post'))
		$this->request->data = $draft['Draft']['content'];
	
	$this->request->data['Draft']['id'] = $id;

	if(!empty($this->data['Event']['id']))
		$this->edit();
	else
		$this->add();
	
	$this->render('add');
}


public function _correct_patient()
{
	//$this->Event->Patient->updateAll( array('Patient.poison_group_id' => 0));
		// $result = $this->Event->find('all',array(
		// 	'fields' => array('id'),
		// 	'contain' => array(
		// 		'Patient' => array(
		// 			'fields' => array('id','poison_group_id'),
		// 			'Substance' =>,
		// 			'AgentsPatient' => array('Agent')
		// 			)
		// 	)
		// 	)
		// ) ;
	set_time_limit(300);
		// $result2 = $this->Event->Patient->find('all',array(
		// 	'conditions'=>array('Patient.poison_group_id !=' => 0),
		// 	'fields' => array('id','poison_group_id'),
		// 	'contain' => array(
		// 		'Substance',
		// 		'AgentsPatient' => array('Agent')
		// 		)
		// 	));


		// foreach ($result2 as $r) {
		// 	$p = $r['Patient'];
		// 	$a = $r['AgentsPatient'];
		// 	$s = $r['Substance'];

		// 	$this->Event->Patient->id = $p['id'];
		// 	if(!empty($s)) {
		// 		foreach ($s as $substance) {
		// 			if($p['poison_group_id'] == $substance['poison_group_id'] && !empty($substance['poison_subgroup_id'])) {
		// 				$this->Event->Patient->saveField('poison_group_id',$substance['poison_subgroup_id']);
		// 				break;
		// 			}

		// 		}
		// 	} else if (!empty($a)) {
		// 		foreach ($a as $agent) {
		// 			if($p['poison_group_id'] == $agent['Agent']['poison_group_id'] && !empty($agent['Agent']['poison_subgroup_id'])) {
		// 				$this->Event->Patient->saveField('poison_group_id',$agent['Agent']['poison_subgroup_id']);
		// 				break;
		// 			}

		// 		}
		// 	}
		// }
	
		//$result_agents = Hash::combine($result,'{n}.Patient.0.id','{n}.Patient.0.AgentsPatient.0.Agent.poison_subgroup_id');
		//$result_substances = Hash::combine($result,'{n}.Patient.0.id','{n}.Patient.0.Substance.0.poison_group_id');
		//$result = Hash::extract($result,'{n}.Patient.AgentsPatient.0.Agent.poison_group_id');
		//pr($result2);
	$final_result = array();
		// foreach ($result as $key => $event) {

		// 	if(!empty($event['Patient'])) {
		// 		$patient = $event['Patient'][0];
		// 		$this->Event->Patient->id = $patient['id'];
		// 		if(!empty($patient['Substance'][0]['poison_group_id'])) {
		// 			$this->Event->Patient->saveField('poison_group_id',$patient['Substance'][0]['poison_group_id']);
		// 			$final_result[] = $patient['Substance'][0]['poison_group_id'];
		// 		}
		// 		elseif(!empty($patient['AgentsPatient'][0]['Agent']['poison_group_id'])) {

		// 			$this->Event->Patient->saveField('poison_group_id',$patient['AgentsPatient'][0]['Agent']['poison_group_id']);
		// 			$final_result[] = $patient['AgentsPatient'][0]['Agent']['poison_group_id'];

		// 		}



		// 	}

		// }


		//$save = $this->Event->Patient->saveMany($final_result);
	pr($final_result);

}
}
