<?php
App::uses('AppModel', 'Model');
/**
 * AgentsAntidote Model
 *
 * @property Agent $Agent
 * @property Antidote $Antidote
 * @property Unit $Unit
 */
class AgentsAntidote extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Agent' => array(
			'className' => 'Agent',
			'foreignKey' => 'agent_id',
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
