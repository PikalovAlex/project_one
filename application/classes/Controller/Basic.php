<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Basic extends Controller_Template {
 
  
 
    public function before()
    {
        parent::before();
        View::set_global('title', 'АИС логистики грузоперевозок');				
        View::set_global('description', 'test');
        $this->template->content = '';
        $this->template->styles = array('style', 'bootstrap', 'datepicker.min');
		$this->template->scripts = array('jquery-3.3.1', 'bootstrap.min', 'datepicker.min', 'jquery-3.0.0.min', 'jquery-3.3.1.min', 'jquery.mask.min', 'json');
    }
 
}