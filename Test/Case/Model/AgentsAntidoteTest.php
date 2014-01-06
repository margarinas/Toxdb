<?php
App::uses('AgentsAntidote', 'Model');

/**
 * AgentsAntidote Test Case
 *
 */
class AgentsAntidoteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.agents_antidote',
		'app.agent',
		'app.unit',
		'app.agents_patient',
		'app.patient',
		'app.event',
		'app.user',
		'app.group',
		'app.event_attribute',
		'app.events_event_attribute',
		'app.patient_attribute_value',
		'app.patient_attribute',
		'app.patient_treatment',
		'app.treatment',
		'app.agents_treatment',
		'app.antidote',
		'app.antidote_attribute',
		'app.antidotes_patient',
		'app.antidotes_treatment',
		'app.patients_treatment_place',
		'app.treatment_place',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute',
		'app.substance',
		'app.agents_substance',
		'app.patients_substance'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AgentsAntidote = ClassRegistry::init('AgentsAntidote');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AgentsAntidote);

		parent::tearDown();
	}

}
