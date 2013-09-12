<?php
App::uses('AgentsPatient', 'Model');

/**
 * AgentsPatient Test Case
 *
 */
class AgentsPatientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.agents_patient',
		'app.agent',
		'app.agents_antidote',
		'app.substance',
		'app.agents_substance',
		'app.patient',
		'app.unit',
		'app.event',
		'app.user',
		'app.group',
		'app.event_attribute',
		'app.events_event_attribute',
		'app.patient_attribute_value',
		'app.patient_event',
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
		'app.patients_substance'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AgentsPatient = ClassRegistry::init('AgentsPatient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AgentsPatient);

		parent::tearDown();
	}

}
