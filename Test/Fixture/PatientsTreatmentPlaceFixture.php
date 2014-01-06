<?php
/**
 * PatientsTreatmentPlaceFixture
 *
 */
class PatientsTreatmentPlaceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'patient_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'treatment_place_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'before' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'recommended' => array('type' => 'boolean', 'null' => true, 'default' => null),
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
			'treatment_place_id' => 1,
			'before' => 1,
			'recommended' => 1
		),
	);

}
