<?php
App::uses('AppModel', 'Model');
/**
 * PatientAttributeValue Model
 *
 * @property Patient $Patient
 * @property PatientEvent $PatientEvent
 * @property PatientAttribute $PatientAttribute
 */
class PatientAttributeValue extends AppModel {


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
		'PatientAttribute' => array(
			'className' => 'PatientAttribute',
			'foreignKey' => 'patient_attribute_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
