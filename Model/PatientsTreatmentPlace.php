<?php
App::uses('AppModel', 'Model');
/**
 * PatientsTreatmentPlace Model
 *
 * @property Patient $Patient
 * @property TreatmentPlace $TreatmentPlace
 */
class PatientsTreatmentPlace extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
public $belongsTo = array(
	'Patient' => array(
		'className' => 'Patient',
		'foreignKey' => 'patient_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		),
	'TreatmentPlace' => array(
		'className' => 'TreatmentPlace',
		'foreignKey' => 'treatment_place_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
		)
	);

public $actsAs = array('Utility.Cacheable'=>array('expires'=>'+24 hours'));


public function listTreatmentPlaceBefore($patient_id) {
	$this->find('list',array(
		'fields'=>array('treatment_place_id'),
		'conditions'=>array('before'=>1,'patient_id'=>$patient_id),
		'cache' => array(__METHOD__, $patient_id)
		)
	);
}

public function listTreatmentPlaceRecommended($patient_id) {
	$this->find('list',array(
		'fields'=>array('treatment_place_id'),
		'conditions'=>array('recommended'=>1,'patient_id'=>$patient_id),
		'cache' => array(__METHOD__, $patient_id)
		)
	);
}
}
