<?php
App::uses('AppModel', 'Model');
/**
 * Draft Model
 *
 * @property User $User
 */
class Draft extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'assoc_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function beforeSave($options =array()) {
		if(!empty($this->data['Draft']['content'])) {
			$this->data['Draft']['content'] = json_encode($this->data['Draft']['content']);
			return true;
		}
		return false;
	}

	public function afterFind($results, $primary = false)
	{
		foreach ($results as $key => $val) {
			if(!empty($results[$key]['Draft']['content']))
				$results[$key]['Draft']['content'] = json_decode($results[$key]['Draft']['content'],true);

		}
		return $results;
	}
}
