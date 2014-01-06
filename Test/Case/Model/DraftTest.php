<?php
App::uses('Draft', 'Model');

/**
 * Draft Test Case
 *
 */
class DraftTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.draft',
		'app.user',
		'app.group',
		'app.event',
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
		'app.call',
		'app.event_attribute',
		'app.events_event_attribute',
		'app.related_event',
		'app.event_relation',
		'app.agents_event',
		'app.events_substance'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Draft = ClassRegistry::init('Draft');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Draft);

		parent::tearDown();
	}

}
