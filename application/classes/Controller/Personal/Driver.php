<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Personal_Driver extends Controller_Common {
    public function action_index() {
			$date = date('Y-m-d');
			// $date = '2018-06-11';
			$user = Auth::instance()->get_user();
			$driver = ORM::factory('driver', array('user_id' => $user->id));
			$car = $driver->car;

			$cnt = $car->routes->where('route_date', '=', $date)->and_where('route_status', '=', '1')->find_all()->count();

			if ($cnt != 0) {
				$route = $car->routes->where('route_date', '=', $date)->and_where('route_status', '=', '1')->find();
				$content = View::factory('personal/driver/main_route', array('route' => $route));
				$this->template->title = 'Панель управления водителя';
				$this->template->description = '';
				$this->template->content = $content;
			}
			else {
				$content = View::factory('personal/driver/main_noroute');
				$this->template->title = 'Панель управления водителя';
				$this->template->description = '';
				$this->template->content = $content;
			}
    }

		public function action_ready() {
			$date = date('Y-m-d');
			// $date = '2018-06-11';
			$user = Auth::instance()->get_user();
			$driver = ORM::factory('driver', array('user_id' => $user->id));
			$car = $driver->car;
			$route = $car->routes->where('route_date', '=', $date)->and_where('route_status', '=', '1')->find();
			$route->route_status = 2;
			$route->save();
			foreach ($route->waypoints->find_all() as $waypoint) {
				$waypoint->order->status_id = 4;
				$waypoint->order->save();
			}
			$this->redirect('/personal/driver');

		}

		public function action_accept() {
			$id = $this->request->param('id');
			$user = Auth::instance()->get_user();
			$driver = ORM::factory('driver', array('user_id' => $user->id));
			$car = $driver->car->car_id;
			$route = ORM::factory('route', $id);
			$route->car_id = $car;
			$route->route_status = 1;
			$route->save();

			foreach ($route->waypoints->find_all() as $waypoint) {
				$waypoint->order->status_id = 3;
				$waypoint->order->save();
			}

			$this->redirect('/personal/driver');
		}

		public function action_history() {
			$user = Auth::instance()->get_user();
			$driver = ORM::factory('driver', array('user_id' => $user->id));
			$car = $driver->car;
			$routes = $car->routes->where('route_status', '=', '2')->order_by('route_date', 'DESC')->find_all();
			$content = View::factory('personal/driver/order_history', array('routes' => $routes));
			$this->template->title = 'Панель управления водителя';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function before() {
			parent::before();
			if (!Auth::instance()->logged_in('driver')) {
				$this->redirect('/personal');
			}
		}
}
