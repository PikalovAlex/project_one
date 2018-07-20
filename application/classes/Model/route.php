<?php defined('SYSPATH') or die('No direct script access.');

class Model_Route extends ORM {
	protected $_primary_key = 'route_id';

	protected $_has_many = array(
		'waypoints' => array(
			'model' => 'waypoint',
			'foreign_key' => 'route_id'
		)
	);

	protected $_belongs_to = array(
		'car' => array(
			'model' => 'car',
			'foreign_key' => 'car_id',
		),
		);
}
