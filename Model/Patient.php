<?php
App::uses('AppModel', 'Model');
/**
 * Patient Model
 *
 * @property Unit $Unit
 * @property Event $Event
 * @property PatientAttributeValue $PatientAttributeValue
 * @property Agent $Agent
 * @property Antidote $Antidote
 * @property Evaluation $Evaluation
 * @property Substance $Substance
 * @property TreatmentPlace $TreatmentPlace
 * @property Treatment $Treatment
 */
class Patient extends AppModel {

/**
 * Display field
 *
 * @var string
 */
public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
public $validate = array(
	'event_id' => array(
		'numeric' => array(
			'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	'name' => array(
		'rule'=>'notEmpty',
		'allowEmpty'=>false,
		'required'=>true,
		'message'=>'Prašome įvesti paciento vardą pavardę arba "Nežinoma"'
		),

	'age_group' => array(
		'rule'=>'notEmpty',
		'allowEmpty'=>false,
		'required'=>true,
		'message'=>'Prašome pasirinkti amžiaus grupę'
		),

	



	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
public $belongsTo = array(
	// 'Unit' => array(
	// 	'className' => 'Unit',
	// 	'foreignKey' => 'unit_id',
	// 	'conditions' => '',
	// 	'fields' => '',
	// 	'order' => ''
	// 	),
	'Event' => array(
		'className' => 'Event',
		'foreignKey' => 'event_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		),
	'PoisonGroup' => array(
		'className' => 'PoisonGroup',
		'foreignKey' => 'poison_group_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		),

	);

/**
 * hasMany associations
 *
 * @var array
 */
public $hasMany = array(
	'PatientAttributeValue' => array(
		'className' => 'PatientAttributeValue',
		'foreignKey' => 'patient_id',
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
	'PatientTreatment' => array(
		'className' => 'PatientTreatment',
		'foreignKey' => 'patient_id',
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
	'PatientsTreatmentPlace' => array(
		'className' => 'PatientsTreatmentPlace',
		'foreignKey' => 'patient_id',
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
	'AgentsPatient' => array(
		'className' => 'AgentsPatient',
		'foreignKey' => 'patient_id',
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
	'AntidotesPatient' => array(
		'className' => 'AntidotesPatient',
		'foreignKey' => 'patient_id',
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
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
public $hasAndBelongsToMany = array(
	'Evaluation' => array(
		'className' => 'Evaluation',
		'joinTable' => 'patients_evaluations',
		'foreignKey' => 'patient_id',
		'associationForeignKey' => 'evaluation_id',
		'unique' => true,
		'conditions' => '',
		'fields' => '',
		'order' => 'Evaluation.order ASC',
		'limit' => '',
		'offset' => '',
		'finderQuery' => '',
		'deleteQuery' => '',
		'insertQuery' => ''
		),
	'PoisoningAttribute' => array(
		'className' => 'PoisoningAttribute',
		'joinTable' => 'patients_poisoning_attributes',
		'foreignKey' => 'patient_id',
		'associationForeignKey' => 'poisoning_attribute_id',
		'unique' => true,
		'conditions' => '',
		'fields' => '',
		'order' => 'PoisoningAttribute.order ASC',
		'limit' => '',
		'offset' => '',
		'finderQuery' => '',
		'deleteQuery' => '',
		'insertQuery' => ''
		),
	'Substance' => array(
		'className' => 'Substance',
		'joinTable' => 'patients_substances',
		'foreignKey' => 'patient_id',
		'associationForeignKey' => 'substance_id',
		'unique' => true,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'finderQuery' => '',
		'deleteQuery' => '',
		'insertQuery' => ''
		)
	);



public function beforeValidate($options = array())
{



	if(!empty($this->data[$this->alias]['type']) && $this->data[$this->alias]['type']=='gyv')
		$this->validator()->remove('age_group');
	
	if(!empty($this->data['PatientAttributeValue'])) {
		foreach ($this->data['PatientAttributeValue'] as $key => $value) {
			if(empty($value['value']))
				unset($this->data['PatientAttributeValue'][$key]);

		}
	}
	

	$treatment_attributes = array(
		'PatientTreatment'=> array(
			'before'=>'TreatmentBefore',
			'recommended'=>'TreatmentRecommended',
			'main_id' =>'treatment_id'
			),
		'PatientsTreatmentPlace'=> array(
			'before'=>'TreatmentPlaceBefore',
			'recommended'=>'TreatmentPlaceRecommended',
			'main_id'=>'treatment_place_id'
			)
		
		);

	foreach ($treatment_attributes as $treatment_key => $attr) {
		if(!empty($this->data['Patient'][$attr['before']])) {
			foreach ($this->data['Patient'][$attr['before']] as $key => $value) {
				$this->data[$treatment_key][$key]['before']=1;
				$this->data[$treatment_key][$key][$attr['main_id']]=$value;
			}

		}

		if(!empty($this->data[$this->alias][$attr['recommended']])) {

			foreach ($this->data[$this->alias][$attr['recommended']] as $value) {
				if(!empty($this->data[$treatment_key]) && in_array(array('before'=>1, $attr['main_id']=>$value), $this->data[$treatment_key])) {
					$key = array_search(array('before'=>1,$attr['main_id']=>$value), $this->data[$treatment_key]);
					$this->data[$treatment_key][$key]['recommended'] = 1;
				} else {
					$this->data[$treatment_key][] = array('recommended'=>1,$attr['main_id']=>$value);
				}
			}

		}
	}


	if(!empty($this->data[$this->alias]['Antidote']) && !empty($this->data['AntidotesPatient'])) {
		$this->data[$this->alias]['Antidote'] = array_unique($this->data[$this->alias]['Antidote']);
		$antidotes = $this->data[$this->alias]['Antidote'];
		foreach ($this->data['AntidotesPatient'] as $key => $antidote_patient) {
			if(!in_array($antidote_patient['antidote_id'],$antidotes)) {
				$this->AntidotesPatient->delete($antidote_patient['id']);
				unset($this->data['AntidotesPatient'][$key]);
			}
			$antidotes = array_diff($antidotes, array($antidote_patient['antidote_id']));
		}
	} else if(!empty($options['saveAllFields'])) {
		$this->AntidotesPatient->deleteAll(array('AntidotesPatient.patient_id'=>$this->id),false);
		unset($this->data['AntidotesPatient']);
	}



	if(!empty($this->data[$this->alias]['Agent']) && !empty($this->data['AgentsPatient'])) {
		$this->data[$this->alias]['Agent'] = array_unique($this->data[$this->alias]['Agent']);
		$agents = $this->data[$this->alias]['Agent'];
		foreach ($this->data['AgentsPatient'] as $key => $agent_patient) {
			if(!in_array($agent_patient['agent_id'],$agents)) {
				
				$this->AgentsPatient->delete($agent_patient['id']);
				unset($this->data['AgentsPatient'][$key]);
			}
			$agents = array_diff($agents, array($agent_patient['agent_id']));
		}
	} else if(!empty($options['saveAllFields'])) {
		$this->AgentsPatient->deleteAll(array('AgentsPatient.patient_id'=>$this->id),false);
		unset($this->data['AgentsPatient']);
	}


	if(!empty($this->data[$this->alias]['Agent']) || !empty($this->data['Substance'])) {
		$this->validator()->add('poison_group_id','required', array(
			'rule'=>'notEmpty',
			'allowEmpty'=>false,
			'required'=>true,
			'message'=>'Prašome pasirinkti pagrindinę medžiagą'
			));
	} else {
		$this->data[$this->alias]['poison_group_id'] = 0;
	}



	return true;
}

public function beforeSave($options=array()) {

	if(!empty($this->data['PoisoningAttribute'])) {
		$this->data['PoisoningAttribute'] =array_values(Hash::flatten($this->data['PoisoningAttribute']));
	}
	
	if(isset($this->data['PatientTreatment']))
		$this->PatientTreatment->deleteAll(array('PatientTreatment.patient_id'=>$this->id),false);

	// if(isset($this->data['AgentsPatient']) || empty($this->data['Patient']['Agent']) && !empty($options['saveAllFields']))
	// 	$this->AgentsPatient->deleteAll(array('AgentsPatient.patient_id'=>$this->id),false);

	if(!isset($this->data['Substance']) && !empty($options['saveAllFields']))
		$this->data['Substance'] = array();

	if(isset($this->data['PatientsTreatmentPlace']))
		$this->PatientsTreatmentPlace->deleteAll(array('PatientsTreatmentPlace.patient_id'=>$this->id),false);

	if(isset($this->data['PatientAttributeValue']))
		$this->PatientAttributeValue->deleteAll(array('PatientAttributeValue.patient_id'=>$this->id),false);
	
	return true;
}

public function afterFind($results, $primary = false) {
	foreach ($results as $key => $val) {

  //       $results[$key]['Patient']['TreatmentBefore'] = $this->PatientTreatment->find('list',array('fields'=>array('treatment_id'),'conditions'=>array('before'=>1,'patient_id'=>$val['Patient']['id'])));
  //       $results[$key]['Patient']['TreatmentRecommended'] = $this->Event->Patient->PatientTreatment->find('list',array('fields'=>array('treatment_id'),'conditions'=>array('recommended'=>1,'patient_id'=>$val['Patient']['id'])));
		// $results[$key]['Patient']['TreatmentPlaceBefore'] = $this->Event->Patient->PatientsTreatmentPlace->find('list',array('fields'=>array('treatment_place_id'),'conditions'=>array('before'=>1,'patient_id'=>$val['Patient']['id'])));
		// $results[$key]['Patient']['TreatmentPlaceRecommended'] = $this->Event->Patient->PatientsTreatmentPlace->find('list',array('fields'=>array('treatment_place_id'),'conditions'=>array('recommended'=>1,'patient_id'=>$val['Patient']['id'])));
  		
  		$results[$key]['Patient']['TreatmentBefore'] = $this->PatientTreatment->listTreatmentBefore($val['Patient']['id']);
        $results[$key]['Patient']['TreatmentRecommended'] = $this->PatientTreatment->listTreatmentRecommended($val['Patient']['id']);
		$results[$key]['Patient']['TreatmentPlaceBefore'] = $this->PatientsTreatmentPlace->listTreatmentPlaceBefore($val['Patient']['id']);
		$results[$key]['Patient']['TreatmentPlaceRecommended'] = $this->PatientsTreatmentPlace->listTreatmentPlaceRecommended($val['Patient']['id']);

    }
    return $results;
}

}
