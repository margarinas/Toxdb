<?php
App::uses('EventAttribute', 'Model');

/**
 * EventAttribute Test Case
 *
 */
class EventAttributeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.event_attribute',
		'app.event',
		'app.user',
		'app.group',
		'app.patient',
		'app.unit',
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
		'app.patients_treatment_place',
		'app.treatment_place',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute',
		'app.events_event_attribute'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EventAttribute = ClassRegistry::init('EventAttribute');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EventAttribute);

		parent::tearDown();
	}

}
