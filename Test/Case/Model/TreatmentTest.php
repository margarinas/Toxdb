<?php
App::uses('Treatment', 'Model');

/**
 * Treatment Test Case
 *
 */
class TreatmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.treatment',
		'app.patient_treatment',
		'app.patient',
		'app.unit',
		'app.event',
		'app.user',
		'app.group',
		'app.event_attribute',
		'app.events_event_attribute',
		'app.patient_attribute_value',
		'app.agent',
		'app.antidote',
		'app.agents_antidote',
		'app.agents_patient',
		'app.substance',
		'app.agents_substance',
		'app.patients_substance',
		'app.agents_treatment',
		'app.patients_antidote',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute',
		'app.treatment_place',
		'app.patients_treatment_place',
		'app.antidotes_treatment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Treatment = ClassRegistry::init('Treatment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Treatment);

		parent::tearDown();
	}

}
