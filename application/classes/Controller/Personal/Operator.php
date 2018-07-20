<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Personal_Operator extends Controller_Common {
    public function action_index() {
			$status = $this->request->query('status');
			if ($status) {
				$orders = ORM::factory('order')->where('status_id', '=', $status)->order_by('date_start', 'DESC')->find_all();
			}
			else {
				$orders = ORM::factory('order')->order_by('date_start', 'DESC')->find_all();
			}
			$statuses = ORM::factory('status')->find_all();
			$content = View::factory('personal/operator/main', array('orders' => $orders, 'statuses' => $statuses));
			$this->template->title = 'Панель управления оператора';
			$this->template->description = '';
			$this->template->content = $content;
    }

		public function action_order_confirm() {
			$id = $this->request->param('id');
			if (!empty($id)) {
 				$order = ORM::factory('order', $id);
				$order->status_id = 2;
				$order->save();
			}
			$this->redirect('/personal/operator');
		}

		public function action_routes() {

		}

		public function action_cancel_order() {
			$id = $this->request->param('id');
			if (!empty($id)) {
 				$order = ORM::factory('order', $id);
				$order->status_id = 5;
				$order->save();
			}
			$this->redirect('/personal/operator');
		}

		public function action_build_route() {
			$content = View::factory('personal/operator/build_route');
			$this->template->title = 'Панель управления оператора';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function before() {
			parent::before();
			if (!Auth::instance()->logged_in('operator')) {
				$this->redirect('/personal');
			}
		}
}
