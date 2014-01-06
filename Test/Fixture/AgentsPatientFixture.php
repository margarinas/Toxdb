<?php
/**
 * AgentsPatientFixture
 *
 */
class AgentsPatientFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'agent_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'patient_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'dose' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'unit_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'agent_id' => 1,
			'patient_id' => 1,
			'dose' => 'Lorem ip',
			'unit_id' => 1
		),
	);

}
