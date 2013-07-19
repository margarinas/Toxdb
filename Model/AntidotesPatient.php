<?php
App::uses('AppModel', 'Model');
/**
 * AntidotesPatient Model
 *
 * @property Patient $Patient
 * @property Antidote $Antidote
 * @property Unit $Unit
 */
class AntidotesPatient extends AppModel {


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
		'Antidote' => array(
			'className' => 'Antidote',
			'foreignKey' => 'antidote_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Unit' => array(
			'className' => 'Unit',
			'foreignKey' => 'unit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
