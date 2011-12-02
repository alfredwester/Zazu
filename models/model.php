<?php
//models are used to get and return things from the database

class Model {
	
	function __construct() {
		
	
	}
	public function user_info() {
		
		//mocked data to simulate a database result
		return array(
			'first' => 'firstData',
			'second' => 'secondData',
			'last' => 'lastData'
		);
	}
}
