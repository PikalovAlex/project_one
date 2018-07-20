<?php defined('SYSPATH') or die('No direct script access.');

Class Model_Car extends ORM {
	protected $_primary_key = 'car_id';
	protected $_belongs_to = array(
		'driver'    => array(
			'model'       => 'driver',
			'foreign_key' => 'driver_id',
		)
	);

	protected $_has_many = array(
		'routes' => array(
			'model' => 'route',
			'foreign_key' => 'car_id'
		)
	);
};
