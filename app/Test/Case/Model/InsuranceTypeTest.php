<?php
App::uses('InsuranceType', 'Model');

/**
 * InsuranceType Test Case
 *
 */
class InsuranceTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.insurance_type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InsuranceType = ClassRegistry::init('InsuranceType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InsuranceType);

		parent::tearDown();
	}

}
