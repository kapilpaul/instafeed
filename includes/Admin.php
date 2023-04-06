<?php
/**
 * The admin class
 *
 * @since 1.0.0
 *
 * @package InstaFeed\Admin
 */

namespace InstaFeed;

/**
 * The admin class
 */
class Admin {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->init_classes();
	}

	/**
	 * Init Classes
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init_classes() {
		new Admin\Menu();
	}

}
