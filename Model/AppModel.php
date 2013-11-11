<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	public $actsAs = array('Containable','Utility.Cacheable');
	public $recursive = -1;

	public function groupList($subgroup='')
	{
		$options = array(
			'fields'=>array('id','name','group'),
			'order'=>'order ASC',
			'cache' => __METHOD__
			);

		if (!empty($subgroup)) {
			$options['fields']= array('id','name','subgroup');
			$options['conditions']=array('group'=>$subgroup);
			$options['cache']=array(__METHOD__, $subgroup);
		}
		return $this->find('list',$options);

	}

	// public function autocomplete($needle, $term)
	// {
	// 	$results = $this->find('all',array('recursive'=>-1,
	// 		'conditions'=>array(
	// 			$needle.' LIKE'=>'%'.$term.'%'
	// 			),
	// 		'fields'=>array($needle,'id'),
	// 		'limit' =>20
	// 		));
	// 	//pr($this->alias);
	// 	$results = Hash::combine($results, '{n}.'.$this->alias.'.'.$needle);
	// 	return array_keys($results);
	// }

	public function autocomplete($needle)
	{
		$results = $this->find('all',array('recursive'=>-1,
			'fields'=>array($needle,'id'),
			'limit' =>20,
			'cache'=>array(__METHOD__,$needle)
			));
		//pr($this->alias);
		$results = Hash::combine($results, '{n}.'.$this->alias.'.'.$needle);
		return array_keys($results);
	}


}


