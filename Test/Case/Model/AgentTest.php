<?php
App::uses('Agent', 'Model');

/**
 * Agent Test Case
 *
 */
class AgentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.agent',
		'app.agent_attribute',
		'app.treatment',
		'app.antidote',
		'app.antidotes_treatment',
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
		$this->Agent = ClassRegistry::init('Agent');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Agent);

		parent::tearDown();
	}

}
