<?php defined('SYSPATH') or die('No direct script access.');

Class Model_Driver extends ORM {
	protected $_primary_key = 'driver_id';
	protected $_belongs_to = array(
		'user' => array(
			'model' => 'user',
			'foreign_key' => 'user_id'
		),
		'car' => array(
				'model'       => 'car',
				'foreign_key' => 'car_id',
			)
	);

};
