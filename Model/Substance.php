<?php
App::uses('AppModel', 'Model');
/**
 * Substance Model
 *
 * @property Agent $Agent
 * @property Patient $Patient
 */
class Substance extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed



	public $belongsTo = array(
		'PoisonGroup'
		);
/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */

	public $hasAndBelongsToMany = array(
		'Agent' => array(
			'className' => 'Agent',
			'joinTable' => 'agents_substances',
			'foreignKey' => 'substance_id',
			'associationForeignKey' => 'agent_id',
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
		'Patient' => array(
			'className' => 'Patient',
			'joinTable' => 'patients_substances',
			'foreignKey' => 'substance_id',
			'associationForeignKey' => 'patient_id',
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

	public $validate = array(
		'name' => array(
			'rule'=>'notEmpty',
			'allowEmpty'=>false,
			'required' => true
			),
		'poison_group_id' => array(
			'rule'=>'numeric',
			'allowEmpty'=>false,
			'message' => 'Pasirinkite grupę'
			)

		);

	// public function find_poison($term)	{
	// 	// $joins = array(
	// 	// 	array(
	// 	// 		'table'=>'agents_substances', 
	// 	// 		'alias' => 'AgentsSubstance',
	// 	// 		'type'=>'left',
	// 	// 		'conditions'=> array(
	// 	// 			'Substance.id = AgentsSubstance.substance_id'
	// 	// 		)),
	// 	// 	array(
	// 	// 		'table'=>'agents', 
	// 	// 		'alias' => 'Agent',
	// 	// 		'type'=>'left',
	// 	// 		'conditions'=> array(
	// 	// 			'Agent.id = AgentsSubstance.agent_id'
	// 	// 		))
	// 	// 	);
	// 	$results = $this->find('all',array(
	// 		// 'contain'=>array('Agent'),
	// 		'recursive'=>-1,
	// 		'conditions' => array(
	// 			'OR' => array(
	// 				'Substance.name LIKE' => '%'.$term.'%',
	// 				'Substance.generic_name LIKE' => '%'.$term.'%',
	// 				// 'Agent.name LIKE' => '%'.$term.'%'
	// 				)
	// 			),
	// 		// 'joins'=>$joins,
	// 		'fields'=>array('Substance.name','Substance.generic_name'/*,'Agent.name'*/),
	// 		'limit' =>20
	// 		));
	// 	//$results = $results['Agent']+$results['Substance'];
	// 	// pr($results);
	// 	// $results = Hash::combine($results, '{n}.Substance.id','{n}.Substance.name')+
	// 	// 			Hash::combine($results, '{n}.Substance.id','{n}.Agent.name')+
	// 	// 			Hash::combine($results, '{n}.Substance.id','{n}.Substance.generic_name');
	// 	$agent_results = $this->Agent->find('all',array(
	// 		'conditions'=>array('Agent.name LIKE' => '%'.$term.'%'),
	// 		'fields'=>array('Agent.name'),
	// 		'limit' => 20
	// 		));

	// 	$final_result = array();
	// 	foreach ($results as $key => $result) {
	// 		// $final_result[] = $result['Agent']['name'];
	// 		$final_result[] = $result['Substance']['name'];
	// 		$final_result[] = $result['Substance']['generic_name'];
	// 	}

	// 	foreach ($agent_results as $key => $agent) {
	// 		$final_result[] = $agent['Agent']['name'];
	// 	}
	// 	//pr($final_result);
	// 	return array_unique(array_values(array_filter($final_result)));
	// }

	public function find_all_poison()	{
		
		return $this->cache(array(__METHOD__), function($model){

			$results = $model->find('all',array(
				'recursive'=>-1,
				'fields'=>array('Substance.name','Substance.generic_name'),
				// 'limit' =>20
				));

			$agent_results = $model->Agent->find('all',array(
				'fields'=>array('Agent.name'),
				// 'limit' => 20
				));

			$final_result = array();
			foreach ($results as $key => $result) {
				$final_result[] = $result['Substance']['name'];
				$final_result[] = $result['Substance']['generic_name'];
			}

			foreach ($agent_results as $key => $agent) {
				$final_result[] = $agent['Agent']['name'];
			}
		
			return array_unique(array_values(array_filter($final_result)));
		});
		
	}


	public function beforeValidate($options = array()) {
		if(isset($this->data[$this->alias]['poison_subgroup_id']) && !empty($this->data[$this->alias]['poison_group_id']))
			$this->data[$this->alias]['poison_group_id'] = $this->data[$this->alias]['poison_subgroup_id'];
		
		return true;
	}

	public function afterFind($results, $primary = false) {
	foreach ($results as $key => $val) {

		if(isset($val[$this->alias]['poison_group_id']))
			$poison_group_id = $val[$this->alias]['poison_group_id'];
		else if(isset($val['poison_group_id']))
			$poison_group_id = $val['poison_group_id'];
		else
			$poison_group_id = null;

		if ($poison_group_id) {

			// $this->PoisonGroup->id = $poison_group_id;
			// $parent_id = $this->PoisonGroup->field('parent_id');

			$parent_poison_group = $this->PoisonGroup->getById($poison_group_id);
			$parent_id = $parent_poison_group['PoisonGroup']['parent_id'];
			
			if(!empty($parent_id)) {
				if($primary) {
					$results[$key][$this->alias]['poison_subgroup_id'] = $results[$key][$this->alias]['poison_group_id'];
					$results[$key][$this->alias]['poison_group_id'] = $parent_id;
				} else {
					$results[$key]['poison_subgroup_id'] = $results[$key]['poison_group_id'];
					$results[$key]['poison_group_id'] = $parent_id;
				}
			}

		}

		
	}
	return $results;
}

public function beforeSave($options = array()) {
	if($this->data[$this->alias]['noagents'] == 1) {
		$this->bindModel(array('hasMany'=>array('AgentsSubstance')));
		$this->AgentsSubstance->deleteAll(array('AgentsSubstance.substance_id'=>$this->data[$this->alias]['id']),false);
	}

}

}
