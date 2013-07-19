<?php
App::uses('Substance', 'Model');

/**
 * Substance Test Case
 *
 */
class SubstanceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.substance',
		'app.agent',
		'app.agent_attribute',
		'app.treatment',
		'app.antidote',
		'app.antidotes_treatment',
		'app.agents_antidote',
		'app.agents_substance',
		'app.patient',
		'app.unit',
		'app.event',
		'app.user',
		'app.group',
		'app.event_attribute',
		'app.events_event_attribute',
		'app.patient_attribute_value',
		'app.agents_patient',
		'app.patients_antidote',
		'app.evaluation',
		'app.patients_evaluation',
		'app.patients_substance',
		'app.treatment_place',
		'app.patients_treatment_place',
		'app.patients_treatment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Substance = ClassRegistry::init('Substance');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Substance);

		parent::tearDown();
	}

}
