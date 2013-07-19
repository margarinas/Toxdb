<?php
App::uses('AppModel', 'Model');
/**
 * PatientTreatment Model
 *
 * @property Patient $Patient
 * @property Treatment $Treatment
 */
class PatientTreatment extends AppModel {


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
		'Treatment' => array(
			'className' => 'Treatment',
			'foreignKey' => 'treatment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


}
