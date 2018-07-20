<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Common {
    public function action_index() {
			$this->redirect('/');
    }

		public function action_login() {
			if (Auth::instance()->logged_in()) {
				$this->redirect('/');
				return;
			}
			$Username = $this->request->post('username');
			$Password = $this->request->post('password');
			if (Auth::instance()->login($Username, $Password, TRUE)) {
				$this->redirect('/');
			}
			else {
				$this->redirect('/?errorLogin');
			}
		}

		public function action_register() {
			if (Auth::instance()->logged_in()) {
				$this->redirect('/');
				return;
			}

			try {
				$Username = $this->request->post('username');
				$Password1 = $this->request->post('password1');
				$Password2 = $this->request->post('password2');
				$Email = $this->request->post('email');
				$FIO = $this->request->post('fio');
				$Phone = $this->request->post('phone');

				$user = ORM::factory('user')
				->create_user(array('username' => $Username, 'email' => $Email, 'password' => $Password1, 'password_confirm' => $Password2), array('username', 'email', 'password'))
				->add('roles', ORM::factory('Role', array('name' => 'login')))
				->save();

				$user->fio = $FIO;
				$user->phone = $Phone;
				$user->save();

			}
			catch (Exception $e) {
				$this->redirect('/register?error=1');
				return;
			}
			$this->redirect('/');
		}

		public function action_logout() {
			if (!Auth::instance()->logged_in()) {
				$this->redirect('/');
				return;
			}
			Auth::instance()->logout(TRUE, FALSE);
			$this->redirect('/');
		}
}
