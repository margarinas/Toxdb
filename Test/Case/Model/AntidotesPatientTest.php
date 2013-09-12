<?php
App::uses('AntidotesPatient', 'Model');

/**
 * AntidotesPatient Test Case
 *
 */
class AntidotesPatientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.antidotes_patient',
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
		'app.agent',
		'app.agents_patient',
		'app.agents_antidote',
		'app.substance',
		'app.agents_substance',
		'app.patients_substance',
		'app.agents_treatment',
		'app.antidote',
		'app.antidote_attribute',
		'app.antidotes_treatment',
		'app.patients_treatment_place',
		'app.treatment_place',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AntidotesPatient = ClassRegistry::init('AntidotesPatient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AntidotesPatient);

		parent::tearDown();
	}

}
