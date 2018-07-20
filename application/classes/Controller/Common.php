<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common extends Controller_Template {

    public $template = 'main';

    public function before()
    {
        parent::before();
        View::set_global('title', 'Диплом');
        View::set_global('description', 'Test');
        $this->template->content = '';
        $this->template->styles = array('style', 'bootstrap', 'datepicker.min');
        $this->template->scripts = array('jquery-3.3.1', 'bootstrap.min', 'datepicker.min', 'jquery.mask.min', 'json');
    }


}
