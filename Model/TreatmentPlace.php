<?php
App::uses('AppModel', 'Model');
/**
 * TreatmentPlace Model
 *
 */
class TreatmentPlace extends AppModel {

/**
 * Display field
 *
 * @var string
 */
public $displayField = 'name';


public $hasMany = array(
	'PatientsTreatmentPlace' => array(
		'className' => 'PatientsTreatmentPlace',
		'foreignKey' => 'treatment_place_id',
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
	);

}
