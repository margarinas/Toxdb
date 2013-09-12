<?php
App::uses('Call', 'Model');

/**
 * Call Test Case
 *
 */
class CallTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.call',
		'app.event',
		'app.user',
		'app.group',
		'app.patient',
		'app.poison_group',
		'app.agent',
		'app.unit',
		'app.agents_patient',
		'app.agents_antidote',
		'app.antidote',
		'app.antidote_attribute',
		'app.antidotes_patient',
		'app.treatment',
		'app.patient_treatment',
		'app.agents_treatment',
		'app.antidotes_treatment',
		'app.substance',
		'app.agents_substance',
		'app.patients_substance',
		'app.patient_attribute_value',
		'app.patient_attribute',
		'app.patients_treatment_place',
		'app.treatment_place',
		'app.evaluation',
		'app.patients_evaluation',
		'app.poisoning_attribute',
		'app.patients_poisoning_attribute',
		'app.event_attribute',
		'app.events_event_attribute',
		'app.related_event',
		'app.event_relation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Call = ClassRegistry::init('Call');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Call);

		parent::tearDown();
	}

}
