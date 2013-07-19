<?php
App::uses('AppModel', 'Model');
/**
 * Treatment Model
 *
 * @property PatientTreatment $PatientTreatment
 * @property Agent $Agent
 * @property Antidote $Antidote
 */
class Treatment extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'PatientTreatment' => array(
			'className' => 'PatientTreatment',
			'foreignKey' => 'treatment_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Agent' => array(
			'className' => 'Agent',
			'joinTable' => 'agents_treatments',
			'foreignKey' => 'treatment_id',
			'associationForeignKey' => 'agent_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Antidote' => array(
			'className' => 'Antidote',
			'joinTable' => 'antidotes_treatments',
			'foreignKey' => 'treatment_id',
			'associationForeignKey' => 'antidote_id',
			'unique' => 'keepExisting',
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

}
