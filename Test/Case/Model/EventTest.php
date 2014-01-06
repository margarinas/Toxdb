<?php
App::uses('Event', 'Model');

/**
 * Event Test Case
 *
 */
class EventTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.event',
		'app.user',
		'app.group',
		'app.call',
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
		// 'app.related_event',
		// 'app.event_relation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Event = ClassRegistry::init('Event');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Event);

		parent::tearDown();
	}

/**
 * testDateFrom method
 *
 * @return void
 */
	public function testDateFrom() {
	}

/**
 * testDateTo method
 *
 * @return void
 */
	public function testDateTo() {
	}

/**
 * testIdFrom method
 *
 * @return void
 */
	public function testIdFrom() {
	}

/**
 * testIdTo method
 *
 * @return void
 */
	public function testIdTo() {
	}

/**
 * testFindByEventAttr method
 *
 * @return void
 */
	public function testFindByEventAttr() {
	}

/**
 * testFindByPatients method
 *
 * @return void
 */
	public function testFindByPatients() {
	}

/**
 * testFindByPoison method
 *
 * @return void
 */
	public function testFindByPoison() {
	}

/**
 * testFindByAntidotes method
 *
 * @return void
 */
	public function testFindByAntidotes() {
	}

/**
 * testFindViewData method
 *
 * @return void
 */
	public function testFindViewData() {
	}

/**
 * testReport method
 *
 * @return void
 */
	public function testReport() {
	}

}
