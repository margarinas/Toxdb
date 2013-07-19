<?php
App::uses('AppModel', 'Model');
/**
 * PatientAttribute Model
 *
 * @property PatientAttributeValue $PatientAttributeValue
 */
class PatientAttribute extends AppModel {

/**
 * Display field
 *
 * @var string
 */
public $displayField = 'name';
public $findMethods = array('group' =>  true);


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
public $hasMany = array(
	'PatientAttributeValue' => array(
		'className' => 'PatientAttributeValue',
		'foreignKey' => 'patient_attribute_id',
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

protected function _findGroup($state, $query, $results = array())
{
	if($state == 'before') {
		$query['fields'] = array('name','group','multiple','type','id');
		return $query;
	}
	
	if($state == 'after') {

		$results = Hash::combine($results, '{n}.PatientAttribute.id','{n}.PatientAttribute','{n}.PatientAttribute.group');
		return $results;
	}

	
}

}
