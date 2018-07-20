<?php defined('SYSPATH') or die('No direct script access.');

class Model_Order extends ORM {
	protected $_primary_key = 'order_id';

	protected $_belongs_to = array(
		'user' => array(
			'model' => 'user',
			'foreign_key' => 'user_id',
		),
		'client' => array(
			'model' => 'client',
			'foreign_key' => 'client_id'
		),
		'status' => array(
			'model' => 'status',
			'foreign_key' => 'status_id'
		),
	);
}
