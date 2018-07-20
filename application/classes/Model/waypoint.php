<?php defined('SYSPATH') or die('No direct script access.');

class Model_Waypoint extends ORM {
	protected $_primary_key = 'waypoint_id';

	protected $_belongs_to = array(
		'route' => array(
			'model' => 'route',
			'foreign_key' => 'route_id',
		),
		'order' => array(
			'model' => 'order',
			'foreign_key' => 'order_id',
		),
	);
}
