<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 * @property User $User
 * @property Patient $Patient
 * @property EventAttribute $EventAttribute
 */
class Event extends AppModel {

	

	
	public $validate = array(

		'requester_name' => array(
			'rule'=>'notEmpty',
			'allowEmpty'=>false,
			'required'=>true,
			'message'=>'Prašome įvesti besikreipiančiojo vardą pavardę'
			),
		'request_type'=> array(
			'rule'=>'notEmpty',
			'allowEmpty'=>false,
			'required'=>true,
			'message'=>'Prašome pasirinkti užklausos tipą'
			),
		'EventAttribute' => array(
			'rule' => array('multiple', array('min' => 4)),
   			'message' => 'Pažymėkite',
   			'allowEmpty'=>false,
			'required'=>true,
			)

		);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
public $hasMany = array(
	'Patient' => array(
		'className' => 'Patient',
		'foreignKey' => 'event_id',
		'dependent' => true,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
		),
	'Call' => array('dependent'=>false)
	);
/**
 * hasOne associations
 *
 * @var array
 */
public $hasOne = array(
	'Draft' => array(
		'className' => 'Draft',
		'foreignKey' => 'assoc_id',
		'dependent' => true,
		'conditions' => array('Draft.model'=>'Event'),
		'fields' => ''
		)
	);
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'EventAttribute' => array(
			'className' => 'EventAttribute',
			'joinTable' => 'events_event_attributes',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'event_attribute_id',
			'unique' => true
		),
		'RelatedEvent' => array(
			'className' => 'RelatedEvent',
			'joinTable' => 'event_relations',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'related_event_id',
			'unique' => true
			),
		'Agent' => array(
			'className' => 'Agent',
			'joinTable' => 'agents_events',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'agent_id',
			'unique' => true
			),
		'Substance' => array(
			'className' => 'Substance',
			'joinTable' => 'events_substances',
			'foreignKey' => 'event_id',
			'associationForeignKey' => 'substance_id',
			'unique' => true
			)
	);


	public $actsAs = array('Search.Searchable');
	 public $filterArgs = array(
        'requester_name' => array('type' => 'like'),
        'id' => array('type' => 'value'),
        'medical_request' => array('type' => 'value'),
        'invalid_request' => array('type' => 'value'),
        'patient_request' => array('type' => 'value'),
        'feedback' => array('type' => 'value'),
        'event_type' => array('type' => 'value', 'field' => 'EventsEventAttribute.event_attribute_id'),
        //'search' => array('type' => 'like', 'field' => 'Article.description'),
        'created_from' => array('type' => 'query', 'method' => 'dateFrom'),
        'created_to' => array('type' => 'query', 'method' => 'dateTo'),
        'id_from' => array('type' => 'query', 'method' => 'idFrom'),
        'id_to' => array('type' => 'query', 'method' => 'idTo'),
        'username' => array('type' => 'like', 'field' => array('User.username', 'User.name')),
        'user_id' => array('type' => 'value'),
        'patient_name' => array('type' => 'like', 'field'=>'Patient.name'),
        'patient_age_group' => array('type' => 'value', 'field'=>'Patient.age_group'),
        'not_poisoning' => array('type' => 'value', 'field' => 'Patient.not_poisoning' ),
        // 'agents' => array('type' => 'subquery', 'method' => 'findByAgents', 'field' => 'Event.id'),
        'antidotes' => array('type' => 'subquery', 'method' => 'findByAntidotes', 'encode' => true,'field' => 'Event.id'),
        // 'substances' => array('type' => 'subquery', 'method' => 'findBySubstances', 'field' => 'Event.id'),
        'poison' => array('type' => 'query', 'method' => 'findByPoison', 'encode' => true),
        'poison_group' => array('type' => 'query', 'method' => 'findByPatients'),
        'patient_poison_group_id' => array('type' => 'query', 'method' => 'findByPatients'),
        'agent_poison_group_id' => array('type' => 'query', 'method' => 'findByPoison'),
        'agent_id' => array('type' => 'query', 'method' => 'findByPoison'),
        'substance_id' => array('type' => 'query', 'method' => 'findByPoison'),
       // 'filter' => array('type' => 'query', 'method' => 'orConditions'),,
        //'enhanced_search' => array('type' => 'like', 'encode' => true, 'before' => false, 'after' => false, 'field' => array('ThisModel.name','OtherModel.name')),
    );

	
	public function dateFrom($data = array()) {
        return array($this->alias . '.created >=' =>  $data['created_from']);
	}

	public function dateTo($data = array()) {
        return array($this->alias . '.created <=' =>  date('Y-m-d H:i:s',strtotime($data['created_to'] . ' + 1 day')));
	}

	public function idFrom($data = array()) {
        return array($this->alias . '.id >=' =>  $data['id_from']);
	}

	public function idTo($data = array()) {
        return array($this->alias . '.id <=' =>  $data['id_to']);
	}

	public function findByEventAttr($data = array()) {
        $this->EventsEventAttribute->Behaviors->attach('Containable', array('autoFields' => false));
        $this->EventsEventAttribute->Behaviors->attach('Search.Searchable');
        $query = $this->EventsEventAttribute->getQuery('all', array(
            'conditions' => array('EventsEventAttribute.event_attribute_id'  => $data['event_type']),
            'fields' => array('event_id')
        ));
        return $query;
    }

	 public function findByPatients($data = array()) {
        // $this->Patient->Behaviors->attach('Containable', array('autoFields' => false,'recursive'=>false));
        // $this->Patient->Behaviors->attach('Search.Searchable');

        $cond = array();
        if(!empty($data['patient_age_group']))
        	$cond['Patient.age_group']= $data['patient_age_group'];
        if(isset($data['patient_name']) && !empty($data['patient_name']))
        	$cond['Patient.name LIKE']  = '%'.$data['patient_name'].'%';

        // if(!empty($data['not_poisoning']))
        // 	$cond['Patient.not_poisoning']= $data['not_poisoning'];


        if(!empty($data['poison_group'])) {
        	if($data['poison_group'] =='hasPoison')
        		$cond['Patient.poison_group_id !='] = 0;

        	else {
        		$cond['AND']['OR'][]['Patient.poison_group_id'] = $data['poison_group'];

        		$poison_subgroup = $this->Patient->PoisonGroup->getListByParentId($data['poison_group']);

        		if($poison_subgroup) {

        			$cond['AND']['OR'][]['Patient.poison_group_id'] = array_keys($poison_subgroup);

        		}
        	}

		}

		if(!empty($data['patient_poison_group_id']))
			$cond[]['Patient.poison_group_id'] = $data['patient_poison_group_id'];
			
		
        // $query = $this->Patient->getQuery('all', array(
        //     'conditions' => $cond,
        //     'fields' => array('event_id'),
        //     'recursive' => -1,
        //     'contain' => array('AgentsPatient'=>array('Agent'),'Substance')
        // ));
        // pr($query);
        return $cond;
    }

	public function findByPoison($data = array()) {
		/*$joins = array(
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
				)),
			);*/
		
		// $this->Patient->Behaviors->attach('Search.Searchable');
		// $this->Patient->Behaviors->attach('Containable', array('autoFields' => false,'recursive'=>false));

		$cond = array();
		if(isset($data['poison']))
			$cond =  array(
				'OR' => array(
					'Agent.name LIKE'  => '%'.$data['poison'].'%',
					'Substance.name LIKE'  => '%'.$data['poison'].'%',
					'Substance.generic_name LIKE'  => '%'.$data['poison'].'%'
					)
				);
		else if(isset($data['agent_id']))
			$cond =  array('Agent.id'=>$data['agent_id']);
		else if(isset($data['substance_id']))
			$cond =  array('Substance.id'=>$data['substance_id']);

		// if(!empty($data['agent_poison_group'])) {
		// 	$cond['AND']['OR']['Agent.poison_group_id'] = $data['agent_poison_group'];
		// 	$cond['AND']['OR']['Substance.poison_group_id'] = $data['agent_poison_group'];

		// 	$poison_subgroup = $this->Patient->Substance->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$data['agent_poison_group'])));

		// 	if($poison_subgroup) {
		// 		$cond['AND']['OR']['Agent.poison_group_id'] = array_keys($poison_subgroup);
		// 		$cond['AND']['OR']['Substance.poison_group_id'] = array_keys($poison_subgroup);
				
		// 	}
			
	
		// }

		if(!empty($data['agent_poison_group_id'])) {
			$cond['AND']['OR']['Agent.poison_group_id'] = $data['agent_poison_group_id'];
			$cond['AND']['OR']['Substance.poison_group_id'] = $data['agent_poison_group_id'];
		}

		// $query = $this->Patient->getQuery('all', array(
  //           //'conditions' => $this->Patient->parseCriteria(array('agents'=>'asd')),
		// 	'conditions' => $cond,
		// 	'fields' => array('Patient.event_id'),
		// 	'recursive' => -1,
		// 	'joins'=>$joins,
		// 	'contain' => array('AgentsPatient'=>array('Agent'),'Substance')
		// 	));
		// pr($query);
		return $cond;
	}

    public function findByAntidotes($data = array()) {
		$joins = array(
			array(
				'table'=>'antidotes_patients', 
				'alias' => 'AntidotesPatient',
				'type'=>'left',
				'conditions'=> array(
					'Patient.id = AntidotesPatient.patient_id'
				)),
			array(
				'table'=>'antidotes', 
				'alias' => 'Antidote',
				'type'=>'inner',
				'conditions'=> array(
					'Antidote.id = AntidotesPatient.antidote_id'
				)),
			);
       $this->Patient->Behaviors->attach('Containable', array('autoFields' => false,'recursive'=>false));
        $this->Patient->Behaviors->attach('Search.Searchable');
        $query = $this->Patient->getQuery('all', array(
            //'conditions' => $this->Patient->parseCriteria(array('antidotes'=>'asd')),
            'conditions' => array('Antidote.name LIKE'  => '%'.$data['antidotes'].'%'),
            'fields' => array('Patient.event_id'),
           'recursive' => -1,
           'joins'=>$joins,
            'contain' => array('AntidotesPatient'=>array('Antidote'))
        ));

        return $query;
    }



    public function findViewData($id=null)
    {
    	$event = array();
    	if($id) {
    		$this->contain(array(
    			'Substance' => array('fields'=>array('id','name')),
    			'Agent' => array('fields'=>array('id','name')),
    			'Patient'=>array(
    				'AntidotesPatient' => array('Antidote','Unit'),
    				'AgentsPatient' => array('Agent','Unit'),
    				'PatientTreatment'=>array('Treatment'),
    				'PatientsTreatmentPlace' => array('TreatmentPlace'),
    				'PatientAttributeValue' => array('PatientAttribute'),
    				'Evaluation',
    				'Substance',
    				'PoisoningAttribute',
    				'PoisonGroup'
    				),
    			'User'=>array('fields'=>'name'),
    			'EventAttribute',
    			'Call'

    			));

    		$event = $this->read(null, $id);

    		$this->bindModel(array('hasOne' => array('EventRelation')));
			$event['RelatedEvent'] = array_values($this->EventRelation->find('list',array('fields'=>array('event_id','related_event_id'),'conditions'=>array('event_id'=>$id))));
    		$event_group_main = Hash::combine($event['EventAttribute'], '{n}.group', '{n}.name', '{n}.subgroup');

    		$event['EventAttribute'] = Hash::combine($event['EventAttribute'], '{n}.id', '{n}.name', '{n}.group');
    		$event['EventAttribute']['main'] = !empty($event_group_main['main'])?$event_group_main['main']:array('type'=>'');

    		if(!empty($event['Patient'])) {
    			$event['Patient'][0]['PoisoningAttribute'] = Hash::combine($event['Patient'][0]['PoisoningAttribute'], '{n}.subgroup', '{n}.name', '{n}.group');

    			$event['Patient'][0]['Evaluation'] = Hash::combine($event['Patient'][0]['Evaluation'],'{n}.id','{n}.name','{n}.group');

    			$event['Patient'][0]['TreatmentBefore'] = Hash::combine($event['Patient'][0]['PatientTreatment'],'{n}[before=1].id','{n}[before=1].Treatment.description');
    			$event['Patient'][0]['TreatmentRecommended'] = Hash::combine($event['Patient'][0]['PatientTreatment'],'{n}[recommended=1].id','{n}[recommended=1].Treatment.description');

    			$event['Patient'][0]['TreatmentPlaceBefore'] = Hash::combine($event['Patient'][0]['PatientsTreatmentPlace'],'{n}[before=1].id','{n}[before=1].TreatmentPlace.name');
    			$event['Patient'][0]['TreatmentPlaceRecommended'] = Hash::combine($event['Patient'][0]['PatientsTreatmentPlace'],'{n}[recommended=1].id','{n}[recommended=1].TreatmentPlace.name');
    		}
    	}

    	return $event;
    }

    public function getEventTypes() {
    	return $this->EventAttribute->find('list',array(
    		'fields'=>array('id','name','subgroup'),
    		'conditions'=>array('group' =>'type')
    		));
    }


    public function getFormLists() {

    	$formLists = array(
    		'eventTypes' => $this->getEventTypes(),
    		'eventAttributes' => $this->EventAttribute->find('list',array(
    			'fields'=>array('id','name','group'),
    			'conditions'=>array('group !=' =>'type')
    			)),
    		'patientAttributes' => $this->Patient->PatientAttributeValue->PatientAttribute->find('group'),
    		'evaluations' => $this->Patient->Evaluation->groupList(),
    		'poisoning_attributes' => $this->Patient->PoisoningAttribute->groupList(),
    		'poisoning_cause' => $this->Patient->PoisoningAttribute->groupList('p_cause'),
    		'poisoning_place' => $this->Patient->PoisoningAttribute->groupList('p_place'),
    		'treatments' => $this->Patient->PatientTreatment->Treatment->find('list',array(
    			'fields'=>array('id','description'),
    			'conditions'=>array('group'=>'basic')
    			)),
    		'treatment_places' => $this->Patient->PatientsTreatmentPlace->TreatmentPlace->find('list'),
    		'users' => $this->User->find('list',array('fields'=>array('id','name')))

    		);


		return $formLists;

    }

	public function beforeValidate($options = array()) {;
		if(empty($this->data[$this->alias]['Call']['id']))
			unset($this->data[$this->alias]['Call']);

		if($this->data[$this->alias]['no_patient']) {
			$this->Patient->deleteAll(array('Patient.event_id'=>$this->id));
			unset($this->data['Patient']);
		}

		if($this->data[$this->alias]['invalid_request']) {
			unset($this->data['Event']['EventAttribute']);
			$this->validator()->remove('EventAttribute');
		}
			
		
		if(!$this->data[$this->alias]['has_related_events'])
			$this->data['RelatedEvent']['RelatedEvent'] = false;
		// $this->data['EventAttribute'][]= $this->data['EventAttribute']['EventAttribute'];
		        // pr($this->data);
		if(isset($this->data['Draft'])){
			$this->data['draft_to_delete'] = $this->data['Draft'];
			unset($this->data['Draft']);
		}
		$this->unbindModel(
			array('hasOne' => array('Draft'))
		);
		
		return true;
	}
	public function beforeSave($options = array()) {

		$this->unbindModel(
			array('hasOne' => array('Draft'))
		);

		if(!empty($options['saveAllFields'])) {
			if(!isset($this->data['Substance']))
				$this->data['Substance'] = array();

			if(!isset($this->data['Agent']))
				$this->data['Agent'] = array();

		}

		return true;
	}
	public function afterSave($created, $options = array())	{
		$cond = array(
			'OR' => array(
				'Draft.assoc_id'=>$this->id
				));
		if(!empty($this->data['Event']['draft_to_delete']['id']))
			$cond['OR']['Draft.id'] = $this->data['Event']['draft_to_delete']['id'];
		$this->Draft->deleteAll($cond, false);
	}

/*	public function report($date_range=array()) {
		set_time_limit(600);
		$report_fields = array(
			'events' => array(),
			'medical_requests' => array('medical_request'=>1),
			'patients_requests' => array('patient_request'=>1),
			'invalid_requests' => array('invalid_request'=>1),
			'not_poisoning' => array('`Event`.`id` IN ('.$this->findByPatients(array('not_poisoning'=>1)).')'),
			'type_event' => array('`Event`.`id` IN ('.$this->findByEventAttr(array('event_type'=>1)).')'),
			'type_incident' => array('`Event`.`id` IN ('.$this->findByEventAttr(array('event_type'=>2)).')'),
			'type_request' => array('`Event`.`id` IN ('.$this->findByEventAttr(array('event_type'=>3)).')'),

			);

		$age_groups = array('adult','child');
		
		if(!empty($date_range['begin_date']) || !empty($date_range['end_date'])) {
			$main_cond = array(
				'Event.created >='=> $date_range['begin_date'],
				'Event.created <' => date('Y-m-d H:i:s',strtotime($date_range['end_date'] . ' + 1 day'))
				);

			foreach ($report_fields as $key => $field) {
				$cond = $main_cond;
				$cond += $field;
				$report[$key] = $this->find('count',array('conditions'=>$cond));
					
			}
			$poison_groups = $this->Patient->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null)));
			
			foreach ($age_groups as $age_group) {
				$cond = $main_cond;
				$cond[] ='`Event`.`id` IN ('.$this->findByPatients(array('patient_age_group'=>$age_group, 'poison_group'=>'hasPoison')).')';
				$report['poison'][$age_group] = $this->find('count',array('conditions'=>$cond));

				foreach ($poison_groups as $group_id => $name) {
					$cond2 = $main_cond;
					$cond2[] = 	'`Event`.`id` IN ('.$this->findByPatients(array('patient_age_group'=>$age_group,'poison_group'=>$group_id)).')';
					$sub_groups = $this->Patient->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>$group_id)));
					//pr(!empty($sub_groups));
					if($sub_groups) {
						$case_count = 0;
						foreach ($sub_groups as $sub_id => $sub_name) {
							//$cond3 = $cond2;
							$cond3 = $main_cond;
							$cond3[] = '`Event`.`id` IN ('.$this->findByPatients(array('patient_age_group'=>$age_group,'patient_poison_group_id'=>$sub_id)).')';
							$report['poison_groups'][$age_group][$name][$sub_name] = $this->find('count',array('conditions'=>$cond3));
							$case_count += $report['poison_groups'][$age_group][$name][$sub_name];
							$report['poison_groups'][$age_group][$name] = array_filter($report['poison_groups'][$age_group][$name]);
						}
						if($case_count)
						 $report['poison_groups'][$age_group][$name]['main'] = $case_count;
					} else {
						$report['poison_groups'][$age_group][$name] = $this->find('count',array('conditions'=>$cond2));
					}
				}
				$report['poison_groups'][$age_group] = array_filter($report['poison_groups'][$age_group]);
			}	

			// pr($report);
			// pr($this->find('all',array('contain'=>array('Patient'),'conditions'=>array(
			// 	'`Event`.`id` IN ('.$this->findByPatients(array('poison_group'=>13)).')',
			// 	'`Event`.`id` IN ('.$this->findByPoison(array('agent_poison_group'=>14)).')',
			// 	)
			// 	)));
			// $poison_groups = $this->Patient->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null)));
			// $events = $this->find('count',array('conditions'=>$main_cond));


		}

		return $report;

	}*/

	public function report($date_range=array()) {
		set_time_limit(600);

		$patient_joins = array(
			array(
				'table'=>'patients', 
				'alias' => 'Patient',
				'type'=>'left',
				'conditions'=> array(
					'Patient.event_id = Event.id'
					)),
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
					)),
			

			);

		$event_type_joins =  array(array(
				'table'=>'events_event_attributes', 
				'alias' => 'EventsEventAttribute',
				'type'=>'left',
				'conditions'=> array(
					'EventsEventAttribute.event_id = Event.id'
					))
		);

		$report_fields = array(
			'events' => array('cond'=>array(),'joins'=>array()),
			'medical_requests' => array('cond'=>array('medical_request'=>1),'joins'=>array()),
			'patients_requests' => array('cond'=>array('patient_request'=>1),'joins'=>array()),
			'invalid_requests' => array('cond'=>array('invalid_request'=>1),'joins'=>array()),
			'not_poisoning' => array('cond'=>array('Patient.not_poisoning'=>1),'joins'=>$patient_joins),
			'type_event' => array('cond'=>array('EventsEventAttribute.event_attribute_id'=>1),'joins'=>$event_type_joins),
			'type_incident' =>array('cond'=>array('EventsEventAttribute.event_attribute_id'=>2),'joins'=>$event_type_joins),
			'type_request' =>array('cond'=>array('EventsEventAttribute.event_attribute_id'=>3),'joins'=>$event_type_joins),

			);

		$age_groups = array('adult','child');
		
		if(!empty($date_range['begin_date']) || !empty($date_range['end_date'])) {
			$main_cond = array(
				'Event.created >='=> $date_range['begin_date'],
				'Event.created <' => date('Y-m-d H:i:s',strtotime($date_range['end_date'] . ' + 1 day'))
				);

			foreach ($report_fields as $key => $field) {
				$cond = $main_cond;
				$cond = array_merge($cond,$field['cond']);
				$report[$key] = $this->find('count',array('conditions'=>$cond, 'joins'=>$field['joins'],'group'=>'Event.id'));
					
			}
			$poison_groups = $this->Patient->PoisonGroup->getListByParentId(null);

			foreach ($age_groups as $age_group) {
				$cond = $main_cond;
				$cond[] =$this->findByPatients(array('patient_age_group'=>$age_group, 'poison_group'=>'hasPoison'));
				$report['poison'][$age_group] = $this->find('count',array('conditions'=>$cond,'joins'=>$patient_joins,'group'=>'Event.id'));

				foreach ($poison_groups as $group_id => $name) {
					$cond2 = $main_cond;
					$cond2[] = 	$this->findByPatients(array('patient_age_group'=>$age_group,'poison_group'=>$group_id,'group'=>'Event.id'));
					$sub_groups = $this->Patient->PoisonGroup->getListByParentId($group_id);
					//pr(!empty($sub_groups));
					if($sub_groups) {
						$case_count = 0;
						foreach ($sub_groups as $sub_id => $sub_name) {
							//$cond3 = $cond2;
							$cond3 = $main_cond;
							$cond3[] = $this->findByPatients(array('patient_age_group'=>$age_group,'patient_poison_group_id'=>$sub_id));
							$report['poison_groups'][$age_group][$name][$sub_name] = $this->find('count',array('conditions'=>$cond3,'joins'=>$patient_joins,'group'=>'Event.id'));
							$case_count += $report['poison_groups'][$age_group][$name][$sub_name];
							$report['poison_groups'][$age_group][$name] = array_filter($report['poison_groups'][$age_group][$name]);
						}
						if($case_count)
						 $report['poison_groups'][$age_group][$name]['main'] = $case_count;
					} else {
						$report['poison_groups'][$age_group][$name] = $this->find('count',array('conditions'=>$cond2,'joins'=>$patient_joins,'group'=>'Event.id'));
					}
				}
				$report['poison_groups'][$age_group] = array_filter($report['poison_groups'][$age_group]);
			}	

			// pr($report);
			// pr($this->find('all',array('contain'=>array('Patient'),'conditions'=>array(
			// 	'`Event`.`id` IN ('.$this->findByPatients(array('poison_group'=>13)).')',
			// 	'`Event`.`id` IN ('.$this->findByPoison(array('agent_poison_group'=>14)).')',
			// 	)
			// 	)));
			// $poison_groups = $this->Patient->PoisonGroup->find('list',array('conditions'=>array('parent_id'=>null)));
			// $events = $this->find('count',array('conditions'=>$main_cond));

		}

		return $report;

	}


	public function asht_report()
	{			

		$joins = array(
			array(
				'table'=>'patients', 
				'alias' => 'Patient',
				'type'=>'left',
				'conditions'=> array(
					'Patient.event_id = Event.id'
					)),
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
					)),

			

			);

		$conversions = [
			'age_group'=>[
				'child'=>'21.0002',
				'adult'=>'21.0001',
				'unknown'=>'21.0003'
			],
			'type' => [
				'vyr' => '22.0001',
				'mot' => '22.0002',
				'gyv' => '22.0003',
				'' => '22.0003'
			]
		];
		$date_range = [
			'begin_date'=>'2013-12-10',
			'end_date'=>'2014-12-31'
		];
		$cond = array(
				'Event.created >='=> $date_range['begin_date'],
				'Event.created <' => date('Y-m-d H:i:s',strtotime($date_range['end_date'] . ' + 1 day')),
				'Patient.poison_group_id' => 20
				);

		$results = $this->find('all',[
			'contain'=>[
				'Patient'=>	[
					'PoisoningAttribute'=>['conditions'=>['asht_code !='=> '']],
					'Evaluation'=>['conditions'=>['asht_code !='=> '']],
					'AgentsPatient'=>['Agent'=>['fields'=>['id','name','cas_number']]],
					'Substance'=>['fields'=>['id','name']],
					'PatientTreatment'=>[
						'Treatment'=>[
							'conditions'=>['asht_code !='=>'']
							]
						]
					],
				],
			'fields'=>[
				
				'Event.id',
				'Event.created',
				// 'Event.type'
				// 'PoisoningAttribute.id'
				],
			'conditions'=>$cond,
			'joins'=>$joins
			]);

		// pr($results);

		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><delivery><caselist /></delivery>');
		$caselist = $xml->caselist;
		foreach ($results as $r) {
			$patient = $r['Patient'][0];
			$evaluations = Hash::combine($patient['Evaluation'], '{n}.group', '{n}.asht_code' );
			$p_attr = Hash::combine($patient['PoisoningAttribute'], '{n}.group', '{n}.asht_code');

			$agents = $patient['Substance'];


			if(!empty($r['Patient']['AgentsPatient']) && !empty($agents))
				$substances = $r['Patient']['AgentsPatient'];
			else if(!empty($r['Patient']['AgentsPatient']) && empty($agents)){
				$substances = '';
				$agents = Hash::combine($r['Patient']['AgentsPatient'], '{n}.id', '{n}.Agent.name');
			} else
				$substances = '';
			$treatments =  array_unique(array_filter(Hash::combine($patient['PatientTreatment'], '{n}.id', '{n}.Treatment.asht_code')));
		
			$case = $caselist->addChild('case');
			$t = $case->addChild('technical');
			$t->addChild('reportingcentre','11.0004');
			$t->addChild('caseidentifier',$r['Event']['id']);
			$t->addChild('firstupload',date('Y-m-d\TH:i:s',strtotime($r['Event']['created'])));
			$t->addChild('preliminary', '');

			$p = $case->addChild('patient');
			$p->addChild('numofpatients',1);
			$p->addChild('age',$patient['age_year']);
			$p->addChild('agegroup',$conversions['age_group'][$patient['age_group']]);
			$p->addChild('sex',$conversions['type'][$patient['type']]);
			$p->addChild('conditions');


			$e = $case->addChild('exposure');
			$e->addChild('datetimeofexposure',date('Y-m-d\TH:i:s',strtotime($patient['time_of_exposure'])));
			$e->addChild('circumstances',$p_attr['p_cause']);
			$e->addChild('exptype',$p_attr['p_type']);
			$e->addChild('likelihood','34.0005');
			$e->addChild('location',$p_attr['p_place']);
			$routelist = $e->addChild('routelist');
			$routelist->addChild('routitem',$p_attr['p_route']);

			$agentlist = $case->addChild('agentlist');
			if(!empty($agents)) {
				foreach ($agents as $agent) {
					$a = $agentlist->addChild('agent');
					$a->addChild('agentcategory','41.0004');
					$a->addChild('agentname',$agent['name']);
					$a->addChild('atccode', '');
					$a->addChild('agentunit','43.0005');
					$a->addChild('unitnumber', '');
					$substlist = $a->addChild('substancelist','');
					if(!empty($substances)) {
						
						foreach ($substances as $subs) {
							$s = $substlist->addChild('substance');
							$s->addChild('substancecode',$subs['Agent']['cas_number']);
							$s->addChild('substancename',$subs['Agent']['name']);
							$s->addChild('substancedose',$subs['dose']);
						}

					}
				}
			}
			$ce = $case->addChild('clinicaleffect','');
			$ce->addChild('causality',$evaluations['symptoms']);
			
			$symptom = $ce->addChild('symptomlist')->addChild('symptom');
			$symptom->addChild('clinicaleffects', '');
			$symptom->addChild('clinicaleffectstext', strip_tags($patient['poisoning_info']));

			$case->addChild('treatments')->addChild('treatmentlist');
			foreach ($treatments as $treatment) {
				$t = $case->treatments->treatmentlist->addChild('treatment');
				$t->addChild('treatmentcode',$treatment);
				$t->addChild('treatmenttext');
			}

			$o = $case->addChild('outcome');
			$o->addChild('severity',$evaluations['grade']);
			$o->addChild('outcome','');

		}

		return html_entity_decode($xml->asXml());
	}

	public function afterFind($results, $primary = false) {

		foreach ($results as $key => $value) {
			if($primary && !empty($value['Event']['id'])) {
				$this->bindModel(array('hasMany' => array('EventRelation')));
				$results[$key]['RelatedEvent']['RelatedEvent'] = array_values($this->EventRelation->find('list',array('conditions'=>array('event_id'=>$value['Event']['id']),'fields'=>array('id','related_event_id'))));
				if(!empty($results[$key]['RelatedEvent']['RelatedEvent']))
					$results[$key]['Event']['has_related_events'] = true;

			}
			
		}
		// pr($results);
		return $results;
	}

}
