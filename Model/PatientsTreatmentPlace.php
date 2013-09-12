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
}
