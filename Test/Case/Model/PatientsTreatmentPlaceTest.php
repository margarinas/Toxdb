<?php
App::uses('PatientsTreatmentPlace', 'Model');

/**
 * PatientsTreatmentPlace Test Case
 *
 */
class PatientsTreatmentPlaceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.patients_treatment_place',
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
		'app.antidotes_patient',
		'app.antidotes_treatment',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute',
		'app.treatment_place'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PatientsTreatmentPlace = ClassRegistry::init('PatientsTreatmentPlace');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PatientsTreatmentPlace);

		parent::tearDown();
	}

}
