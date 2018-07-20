<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Personal_Main extends Controller_Common {
    public function action_index() {
			if (Auth::instance()->logged_in('admin')) {
				$this->redirect('/personal/admin');
			}
			else if (Auth::instance()->logged_in('operator')) {
				$this->redirect('/personal/operator');
			}
			else if (Auth::instance()->logged_in('driver')) {
				$this->redirect('/personal/driver');
			}
			else if (Auth::instance()->logged_in()) {
				$this->redirect('/personal/client');
			}
			else {
				$this->redirect('/');
			}
    }
}
