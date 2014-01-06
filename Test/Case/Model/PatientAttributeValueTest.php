<?php
App::uses('PatientAttributeValue', 'Model');

/**
 * PatientAttributeValue Test Case
 *
 */
class PatientAttributeValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.patient_attribute_value',
		'app.patient',
		'app.unit',
		'app.event',
		'app.user',
		'app.group',
		'app.event_attribute',
		'app.events_event_attribute',
		'app.patient_treatment',
		'app.treatment',
		'app.agent',
		'app.antidote',
		'app.agents_antidote',
		'app.agents_patient',
		'app.substance',
		'app.agents_substance',
		'app.patients_substance',
		'app.agents_treatment',
		'app.antidotes_treatment',
		'app.patients_antidote',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute',
		'app.treatment_place',
		'app.patients_treatment_place',
		'app.patient_event',
		'app.patient_attribute'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PatientAttributeValue = ClassRegistry::init('PatientAttributeValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PatientAttributeValue);

		parent::tearDown();
	}

}
