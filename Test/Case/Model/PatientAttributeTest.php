<?php
App::uses('PatientAttribute', 'Model');

/**
 * PatientAttribute Test Case
 *
 */
class PatientAttributeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.patient_attribute',
		'app.patient_attribute_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PatientAttribute = ClassRegistry::init('PatientAttribute');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PatientAttribute);

		parent::tearDown();
	}

}
