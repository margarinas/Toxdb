<?php
App::uses('TreatmentPlace', 'Model');

/**
 * TreatmentPlace Test Case
 *
 */
class TreatmentPlaceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.treatment_place'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TreatmentPlace = ClassRegistry::init('TreatmentPlace');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TreatmentPlace);

		parent::tearDown();
	}

}
