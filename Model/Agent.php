<?php
App::uses('AppModel', 'Model');
/**
 * Agent Model
 *
 * @property Antidote $Antidote
 * @property Patient $Patient
 * @property Substance $Substance
 * @property Treatment $Treatment
 */
class Agent extends AppModel {

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
		'message' => 'Įveskite pavadinimą'
				//'required' => true
		),
	'poison_group_id' => array(
		'rule'=>'numeric',
		'allowEmpty'=>false,
		'message' => 'Pasirinkite grupę'
		)

	);


	//The Associations below have been created with all possible keys, those that are not needed can be removed

public $belongsTo = array('Unit','PoisonGroup'=>array('order'=>'PoisonGroup.order ASC'));

public $hasMany = array(
	'AgentsPatient' => array(
		'className' => 'AgentsPatient',
		'foreignKey' => 'agent_id',
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
		'foreignKey' => 'agent_id',
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


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
public $hasAndBelongsToMany = array(
	'Substance' => array(
		'className' => 'Substance',
		'joinTable' => 'agents_substances',
		'foreignKey' => 'agent_id',
		'associationForeignKey' => 'substance_id',
		'unique' => true,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'finderQuery' => '',
		'deleteQuery' => '',
		'insertQuery' => ''
		),
	'Treatment' => array(
		'className' => 'Treatment',
		'joinTable' => 'agents_treatments',
		'foreignKey' => 'agent_id',
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

// public function deleteAssoc($id = null) {
// 	$this->bindModel(array('hasMany'=>array('AgentsSubstance')));
// 	$this->AgentsSubstance->deleteAll(array(''))
// }

public function beforeValidate($options = array()) {
		if(isset($this->data[$this->alias]['poison_subgroup_id']) && !empty($this->data[$this->alias]['poison_group_id']))
			$this->data[$this->alias]['poison_group_id'] = $this->data[$this->alias]['poison_subgroup_id'];
		
		
		// $this->data['EventAttribute'][]= $this->data['EventAttribute']['EventAttribute'];
		//         pr($this->data);
		return true;
}

public function afterFind($results, $primary = false) {

	foreach ($results as $key => $val) {

		if(isset($val['Agent']['poison_group_id']))
			$poison_group_id = $val['Agent']['poison_group_id'];
		elseif (isset($val['poison_group_id']) && is_numeric($key))
			$poison_group_id = $val['poison_group_id'];
		elseif ($key=='poison_group_id' && is_string($key))
			$poison_group_id = $val;
		else
			$poison_group_id = null;

		if ($poison_group_id) {
			$this->PoisonGroup->id = $poison_group_id;
			$parent_id = $this->PoisonGroup->field('parent_id');
			if(!empty($parent_id)) {
				if($primary) {
					$results[$key]['Agent']['poison_subgroup_id'] = $results[$key]['Agent']['poison_group_id'];
					$results[$key]['Agent']['poison_group_id'] = $parent_id;
				} elseif(is_numeric($key)){
					$results[$key]['poison_subgroup_id'] = $results[$key]['poison_group_id'];
					$results[$key]['poison_group_id'] = $parent_id;
				} elseif(is_string($key)) {
					$results['poison_subgroup_id'] = $results['poison_group_id'];
					$results['poison_group_id'] = $parent_id;
				}
			}

		}

		
	}
	return $results;
}

}
