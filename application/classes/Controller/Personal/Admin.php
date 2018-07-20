<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Personal_Admin extends Controller_Common {
    public function action_index() {
			$drivers = ORM::factory('driver')->find_all();
			$cars = ORM::factory('car')->find_all();
			$operators = ORM::factory('role', 3)->users->find_all();

			$jsonData = file_get_contents('formula.json');
			$koeff = json_decode($jsonData, true);
			$p = $koeff['p'];
			$c = $koeff['c'];
			$q = $koeff['q'];

			$content = View::factory('personal/admin/main', array('drivers' => $drivers, 'cars' => $cars, 'operators' => $operators, 'p' => $p, 'c' => $c, 'q' => $q));
			$this->template->title = 'Панель управления администратора';
			$this->template->description = '';
			$this->template->content = $content;
    }

		public function action_driver_history() {
			$id = $this->request->param('id');
			$driver = ORM::factory('driver', $id);

			$content = View::factory('personal/admin/driver_history', array('driver' => $driver));
			$this->template->title = 'Информация о водителе';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_add_driver() {
			$cars = ORM::factory('car')->find_all();
			$content = View::factory('personal/admin/add_driver', array('cars' => $cars));
			$this->template->title = 'Добавление водителя';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_add_driver_process() {
			try {
				$name = $this->request->post('name');
				$car_id = $this->request->post('car');
				$pasport = $this->request->post('pasport');
				$login = $this->request->post('login');
				$password = $this->request->post('password');
				$email = $this->request->post('email');

				$user = ORM::factory('user')
				->create_user(array('username' => $login, 'email' => $email, 'password' => $password, 'password_confirm' => $password), array('username', 'email', 'password'))
				->add('roles', ORM::factory('role', array('name' => 'login')))
				->add('roles', ORM::factory('role', array('name' => 'driver')))
				->set('fio', $name)
				->set('phone', '')
				->save();

				$driver = ORM::factory('driver');
				$driver->driver_pasport = $pasport;
				$driver->driver_name = '';
				$driver->car_id = $car_id;
				$driver->user_id = $user->id;
				$driver->save();

			}
			catch (Exception $e) {
				$this->redirect('/personal/admin/add_driver/?error');
			}
			$this->redirect('/personal/admin');
		}

		public function action_change_driver() {
			$id = $this->request->param('id');
			$driver = ORM::factory('driver', $id);
			$cars = ORM::factory('car')->find_all();
			$content = View::factory('personal/admin/change_driver', array('driver' => $driver, 'cars' => $cars));
			$this->template->title = 'Редактирование водителя';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_change_driver_process() {
			$id = $this->request->post('id');
			try {
				$name = $this->request->post('name');
				$pasport = $this->request->post('pasport');
				$car_id = $this->request->post('car');
				$email = $this->request->post('email');
				$password = $this->request->post('password');
				// var_dump($_POST);
				$driver = ORM::factory('driver', $id);
				$driver->user->fio = $name;
				$driver->user->email = $email;
				$driver->car_id = $car_id;
				$driver->driver_pasport = $pasport;
				if (!empty($password)) {
					$driver->user->password = $password;
				}
				$driver->user->save();
				$driver->save();

			}
			catch (Exception $e) {
				$this->redirect('/personal/admin/change_driver/' . $id . '?error');
			}
			$this->redirect('/personal/admin');
		}

		public function action_add_car() {
			$content = View::factory('personal/admin/add_car');
			$this->template->title = 'Добавление автомобиля';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_add_car_process() {
			try {
				$name = $this->request->post('name');
				$type = $this->request->post('type');
				$number = $this->request->post('number');
				$capacity = $this->request->post('capacity');

				$car = ORM::factory('car');
				$car->car_name = $name;
				$car->car_type = $type;
				$car->car_number = $number;
				$car->car_capacity = $capacity;

				$car->save();

			}
			catch (Exception $e) {
				$this->redirect('/personal/admin/add_car/?error');
			}
			$this->redirect('/personal/admin');
		}

		public function action_change_car() {
			$id = $this->request->param('id');
			$car = ORM::factory('car', $id);
			$content = View::factory('personal/admin/change_car', array('car' => $car));
			$this->template->title = 'Редактирование автомобиля';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_change_car_process() {
			$id = $this->request->post('id');
			try {
				$name = $this->request->post('name');
				$type = $this->request->post('type');
				$number = $this->request->post('number');

				$car = ORM::factory('car', $id);
				$car->car_name = $name;
				$car->car_number = $number;
				$car->car_type = $type;

				$car->save();

			}
			catch (Exception $e) {
				$this->redirect('/personal/admin/change_car/' . $id . '?error');
			}
			$this->redirect('/personal/admin');
		}

		public function action_add_operator() {
			$content = View::factory('personal/admin/add_operator');
			$this->template->title = 'Добавление оператора';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_add_operator_process() {
			try {
				$login = $this->request->post('login');
				$name = $this->request->post('name');
				$email = $this->request->post('email');
				$password = $this->request->post('password');

				$user = ORM::factory('user')
				->create_user(array('username' => $login, 'email' => $email, 'password' => $password, 'password_confirm' => $password), array('username', 'email', 'password'))
				->add('roles', ORM::factory('role', array('name' => 'login')))
				->add('roles', ORM::factory('role', array('name' => 'operator')))
				->set('fio', $name)
				->save();
			}
			catch (Exception $e) {
				$this->redirect('/personal/admin/add_operator/?error');
			}
			$this->redirect('/personal/admin');
		}

		public function action_change_operator() {
			$id = $this->request->param('id');
			$operator = ORM::factory('user', $id);

			$content = View::factory('personal/admin/change_operator', array('operator' => $operator));
			$this->template->title = 'Редактирование оператора';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_change_operator_process() {
			$id = $this->request->post('id');
			try {
				$name = $this->request->post('name');
				$email = $this->request->post('email');
				$password = $this->request->post('password');
				$operator = ORM::factory('user', $id);
				$operator->fio = $name;
				$operator->email = $email;
				if (!empty($password)) {
					$operator->password = $password;
				}
				$operator->save();
			}
			catch (Exception $e) {
				$this->redirect('/personal/admin/change_operator/' . $id . '?error');

			}
			$this->redirect('/personal/admin');
		}

		public function action_change_koeff() {
			$jsonData = file_get_contents('formula.json');
			$koeff = json_decode($jsonData, true);
			$p = $koeff['p'];
			$c = $koeff['c'];
			$q = $koeff['q'];
			$content = View::factory('personal/admin/change_koeff', array('q' => $q, 'c' => $c, 'p' => $p));
			$this->template->title = 'Редактирование коэффициентов';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_change_koeff_process() {
			$koeff['q'] = (int)$this->request->post('q');
			$koeff['c'] = (int)$this->request->post('c');
			$koeff['p'] = (int)$this->request->post('p');

			file_put_contents('formula.json', json_encode($koeff));

			$this->redirect('/personal/admin');
		}

		public function before() {
			parent::before();
			if (!Auth::instance()->logged_in('admin')) {
				$this->redirect('/personal');
			}
		}
}
