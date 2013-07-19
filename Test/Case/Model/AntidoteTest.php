<?php
App::uses('Antidote', 'Model');

/**
 * Antidote Test Case
 *
 */
class AntidoteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.antidote',
		'app.antidote_attribute',
		'app.agents_antidote',
		'app.antidote_patient[1;5_d[d[d[d[d[d[ds[2~patient',
		'app.patients_antidote',
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
		'app.patient_event',
		'app.patient_attribute',
		'app.agents_patient',
		'app.antidotes_patient',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute',
		'app.substance',
		'app.agent',
		'app.agents_substance',
		'app.agents_treatment',
		'app.patients_substance',
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
		$this->Antidote = ClassRegistry::init('Antidote');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Antidote);

		parent::tearDown();
	}

}
