<?php
/**
 * AntidotesPatientFixture
 *
 */
class AntidotesPatientFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'patient_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'antidote_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'dose' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'before' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'recommended' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'patient_id' => 1,
			'antidote_id' => 1,
			'dose' => 'Lorem ip',
			'before' => 1,
			'recommended' => 1,
			'unit_id' => 1
		),
	);

}
