<?php
App::uses('AppModel', 'Model');
/**
 * Antidote Model
 *
 * @property AntidoteAttribute $AntidoteAttribute
 * @property AgentsAntidote $AgentsAntidote
 * @property PatientsAntidote $PatientsAntidote
 * @property Treatment $Treatment
 */
class Antidote extends AppModel {

/**
 * Display field
 *
 * @var string
 */
public $displayField = 'name';

public $validate = array(
	'name' => array(
		'rule'=>'notEmpty',
		'allowEmpty'=>false,
				//'required' => true
		),

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

public $belongsTo = array('Unit');

/**
 * hasMany associations
 *
 * @var array
 */
public $hasMany = array(
	'AntidoteAttribute' => array(
		'className' => 'AntidoteAttribute',
		'foreignKey' => 'antidote_id',
		'dependent' => false,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
		),
	'AgentsAntidote' => array(
		'className' => 'AgentsAntidote',
		'foreignKey' => 'antidote_id',
		'dependent' => false,
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
		'foreignKey' => 'antidote_id',
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
	'Treatment' => array(
		'className' => 'Treatment',
		'joinTable' => 'antidotes_treatments',
		'foreignKey' => 'antidote_id',
		'associationForeignKey' => 'treatment_id',
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
