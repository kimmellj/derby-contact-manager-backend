<?php
App::uses('AuthorizedContact', 'Model');

/**
 * AuthorizedContact Test Case
 *
 */
class AuthorizedContactTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.authorized_contact',
		'app.contact',
		'app.organization',
		'app.contacts_organization',
		'app.role',
		'app.contacts_role'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AuthorizedContact = ClassRegistry::init('AuthorizedContact');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AuthorizedContact);

		parent::tearDown();
	}

}
