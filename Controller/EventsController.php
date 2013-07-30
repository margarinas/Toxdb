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



	$limit = $this->request->is('ajax')?7:20;

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


	$events = $this->paginate();
		
	$showSearch = (!empty($this->data['Event']) || empty($events))?:false;
	$this->set('showSearch','in');
	$this->set('events', $events);


	$eventTypes =  $this->Event->getEventTypes();
	$this->set('eventType',$eventTypes['main']);
	$this->set('poison_group',$this->Agent->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null),'order'=>'PoisonGroup.order ASC')));

}

public function find()
{


	$this->Prg->commonProcess();
	$parsedParams = $this->Prg->parsedParams();

	$limit = $this->params['named']['event_per_page'];
	$this->request->data['Event']['event_per_page'] = $limit;
	$this->paginate = array(
		'order' => 'Event.created DESC',
		'contain' => array(
			'Substance' => array('fields'=>array('id','name')),
			'Agent' => array('fields'=>array('id','name')),
			'Patient' => array(
				'fields'=>array('Patient.name','Patient.id'),
				'AgentsPatient' => array('Agent'=>array('fields'=>array('id','name'))),
				'Substance' => array('fields'=>array('name','id'))
				),
			'User'=>array('fields'=>array('id','name'))
			),
		'conditions' => $this->Event->parseCriteria($this->Prg->parsedParams()),
		'limit' => !empty($limit)?$limit:20
		);


	//$this->request->data['Event'] += $this->passedArgs;


	$eventTypes = $this->Event->getEventTypes();

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
		pr($this->request->query);
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

	$eventAttributes = $this->Event->EventAttribute->find('list',array(
		'fields'=>array('id','name','group'),
		'conditions'=>array('group !=' =>'type')
		));

	$eventTypes = $this->Event->getEventTypes();

	$patientAttributes = $this->PatientAttribute->find('group');

	$evaluations = $this->Event->Patient->Evaluation->groupList();
	$poisoning_attributes = $this->Event->Patient->PoisoningAttribute->groupList();
	$poisoning_cause = $this->Event->Patient->PoisoningAttribute->groupList('p_cause');;
	$poisoning_place = $this->Event->Patient->PoisoningAttribute->groupList('p_place');

	$treatments = $this->Event->Patient->PatientTreatment->Treatment->find('list',array(
		'fields'=>array('id','description'),
		'conditions'=>array('group'=>'basic')
		));

	$treatment_places = $this->Event->Patient->PatientsTreatmentPlace->TreatmentPlace->find('list');

	$users = $this->Event->User->find('list',array('fields'=>array('id','name')));
	$units = $this->Unit->groupList();

	$this->set(compact('users','eventAttributes','eventTypes','patientAttributes','evaluations','poisoning_attributes','poisoning_cause','poisoning_place','treatments','treatment_places','units','substances','agents','antidotes'));

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
		'Agent'
		));



	if (!$this->Event->exists()) {
		throw new NotFoundException(__('Invalid event'));
	}

	$eventAttributes = $this->Event->EventAttribute->find('list',array(
		'fields'=>array('id','name','group'),
		'conditions'=>array('group !=' =>'type')
		));

	$eventTypes = $this->Event->getEventTypes();

	$patientAttributes = $this->PatientAttribute->find('group');
	$evaluations = $this->Event->Patient->Evaluation->groupList();
	$poisoning_attributes = $this->Event->Patient->PoisoningAttribute->groupList();
	$poisoning_cause = $this->Event->Patient->PoisoningAttribute->groupList('p_cause');;
	$poisoning_place = $this->Event->Patient->PoisoningAttribute->groupList('p_place');


	$treatments = $this->Event->Patient->PatientTreatment->Treatment->find('list',array(
		'fields'=>array('id','description'),
		'conditions'=>array('group'=>'basic')
		));
	$treatment_places = $this->Event->Patient->PatientsTreatmentPlace->TreatmentPlace->find('list');

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





	$users = $this->Event->User->find('list',array('fields'=>array('id','name')));
	$units = $this->Unit->find('list',array('fields'=>array('id','name','group')));
	
	$this->set(compact('users','eventAttributes','eventTypes','patientAttributes','evaluations','poisoning_attributes','poisoning_cause','poisoning_place','treatments','treatment_places','units','substances','agents','antidotes'));
	$this->render('/Events/add');
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
	$this->Event->id = $id;
	if (!$this->Event->exists()) {
		throw new NotFoundException(__('Invalid event'));
	}
	if ($this->Event->delete()) {
		$this->Session->setFlash(__('Event deleted'));
		$this->redirect(array('action' => 'index'));
	}
	$this->Session->setFlash(__('Event was not deleted'));
	$this->redirect(array('action' => 'index'));
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

public function draft() {
	if($this->request->is('post')) {
		//$this->
	}
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
