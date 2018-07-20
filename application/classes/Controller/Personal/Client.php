<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Personal_Client extends Controller_Common {
    public function action_index() {
			$user = Auth::instance()->get_user();
			$orders = ORM::factory('order')->where('user_id', '=', $user->id)->order_by('date_start', 'DESC')->find_all();
			$content = View::factory('personal/client/main', array('orders' => $orders));
			$this->template->title = 'Личный кабинет';
			$this->template->description = '';
			$this->template->content = $content;
    }

		public function action_change_order() {
			$id = $this->request->param('id');
			$order = ORM::factory('order', $id);
			$order->date_start = date('d.m.Y', strtotime($order->date_start));
			$content = View::factory('personal/client/change_order', array('order' => $order));
			$this->template->title = 'Редактирование заказа';
			$this->template->description = '';
			$this->template->content = $content;
		}

		public function action_change_order_process() {
			$id = $this->request->post('id');
			try {
				$date = $this->request->post('date');
				$size = $this->request->post('size');
				$comment = $this->request->post('comment');
				$cost = $this->request->post('cost');
				$address = $this->request->post('endpoint');
				$coordinates = $this->request->post('coordinates');

				$date = strtotime($date);
				$date = date('Y-m-d', $date);
				$dateCreate = date('Y-m-d H:m:i');

				$order = ORM::factory('order', $id);
				$order->order_create_date = $dateCreate;
				$order->date_start = $date;
				$order->order_capacity = $size;
				$order->order_cost = $cost;
				$order->order_address = $address;
				$order->order_coordinates = $coordinates;
				$order->order_comment = $comment;
				$order->save();

			}
			catch (Exception $e) {
				$this->redirect('/personal/client/change_order/' . $id . '?error');
			}
			$this->redirect('/personal/client');
		}

		public function action_delete_order() {
			$id = $this->request->param('id');
			try {
				$order = ORM::factory('order', $id);
				$order->delete();
			}
			catch (Exception $e) {
				$this->redirect('/personal/client/delete_order/' . $id . '?error');
			}
			$this->redirect('/personal/client');
		}

		public function before() {
			parent::before();
			if (!Auth::instance()->logged_in()) {
				$this->redirect('/personal');
			}
		}
}
