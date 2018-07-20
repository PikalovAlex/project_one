<?php defined('SYSPATH') or die('No direct script access.');

class Controller_API extends Controller {
    public function action_index() {
			echo 'ok';
    }

		public function action_calc_cost() {
			$w = $this->request->query('w');
			$v = $this->request->query('v');
			$l = $this->request->query('l');

			$jsonData = file_get_contents('formula.json');
			$koeff = json_decode($jsonData, true);

			$p = $koeff['p'];
			$c = $koeff['c'];
			$q = $koeff['q'];

			$sum = $v * $p + $c * $l + $q * $w;
			echo json_encode($sum);
		}

		public function action_rt() {
			$route = $this->request->query('route');
			$route = ORM::factory('route', $route);
			$waypoints = ORM::factory('waypoint')->where('route_id', '=', $route)->find_all();
			$result = [['place' => 'Липецк, Московская 30']];
			foreach ($waypoints as $waypoint) {
				$tmp = [
					'place' => $waypoint->order->order_address,
					'capacity' => $waypoint->order->order_capacity,
					'cost' => $waypoint->order->order_cost,
					'weight' => $waypoint->order->order_comment,
				];
				if ($waypoint->order->client_id) {
					$tmp['name'] = $waypoint->order->client->client_name;
					$tmp['mobile'] = $waypoint->order->client->client_mobile;
				}
				else {
					$tmp['name'] = $waypoint->order->user->fio;
					$tmp['mobile'] = $waypoint->order->user->phone;
				}
				$result[] = $tmp;
			}

			echo json_encode($result, JSON_UNESCAPED_UNICODE);
		}

		public function action_route() {
			$date = $this->request->query('date');
			$date = strtotime($date);
			$date = date('Y-m-d', $date);
			// $date = date('Y-m-d');
			$readyRoutes = [];
			$routesCnt = ORM::factory('route')->where('route_date', '=', $date)->and_where('route_status', '=', '0')->find_all()->count();
			if ($routesCnt != 0) {
				$routes = ORM::factory('route')->where('route_date', '=', $date)->and_where('route_status', '=', '0')->find_all();
				foreach ($routes as $route) {
					$rt = [['id' => '-1', 'place' => 'Липецк,ул.Московская30']];
					foreach ($route->waypoints->find_all() as $waypoint) {
						$tmpRoute = [
							'id' => $waypoint->order->order_id,
							'place' => $waypoint->order->order_address,
							'cost' => $waypoint->order->order_cost,
							'capacity' => $waypoint->order->order_capacity,
							'weight' => $waypoint->order->order_comment,
						];
						if ($waypoint->order->client_id) {
							$tmpRoute['mobile'] = $waypoint->order->client->client_mobile;
							$tmpRoute['name'] = $waypoint->order->client->client_name;
						}
						else {
							$tmpRoute['mobile'] = $waypoint->order->user->phone;
							$tmpRoute['name'] = $waypoint->order->user->fio;
						}
						$rt[] = $tmpRoute;
					}
					$readyRoutes[] = ['route' => $route->route_id, 'routes' => $rt];
				}
			}
			echo json_encode($readyRoutes, JSON_UNESCAPED_UNICODE);
		}

		public function action_routes() {
			$date = $this->request->query('date');
			$date = strtotime($date);
			$date = date('Y-m-d', $date);
			$routesCnt = ORM::factory('route')->where('route_date', '=', $date)->find_all()->count();
			$carsCnt = ORM::factory('car')->find_all()->count();

			$readyRoutes = [];
			if ($routesCnt != 0) {
				$routes = ORM::factory('route')->where('route_date', '=', $date)->find_all();
				foreach ($routes as $route) {
					$rt = [['id' => '-1', 'place' => 'Липецк,ул.Московская30']];
					foreach ($route->waypoints->find_all() as $waypoint) {
						$tmpRoute = [
							'id' => $waypoint->order->order_id,
							'place' => $waypoint->order->order_address,
							'cost' => $waypoint->order->order_cost,
							'capacity' => $waypoint->order->order_capacity,
							'weight' => $waypoint->order->order_comment,
						];
						if ($waypoint->order->client_id) {
							$tmpRoute['mobile'] = $waypoint->order->client->client_mobile;
							$tmpRoute['name'] = $waypoint->order->client->client_name;
						}
						else {
							$tmpRoute['mobile'] = $waypoint->order->user->phone;
							$tmpRoute['name'] = $waypoint->order->user->fio;
						}
						$rt[] = $tmpRoute;
					}
					$readyRoutes[] = $rt;
				}
			}

			$orders = ORM::factory('order')->where('date_start', '=', $date)->where('order_route', '=', '0')->and_where('status_id', '=', '2')->find_all()->as_array();
			
			// if () {
				// $result = ['routes' => [], 'orders' => [], 'readyroutes' => []];
				// echo json_encode($result, JSON_UNESCAPED_UNICODE);
				// return;
			// }
			
			$routes = [];
			$ordersTmp = $orders;
			$selectedOrder = [];

			// Основной цикл
			$route = [];
			$first = true;
			$currentCapacity = 0;
			$currentWeight = 0;
			// while ((count($ordersTmp) != 0) && (count($orders) != 0)) {
			$z = 0;
			while ($z < 30 && count($orders) != 0) {
				$z++;
				//Если остался один невыбранный заказ
				if (count($ordersTmp) == 1) {
					//Проверяем вместимость
					if (($currentCapacity + $ordersTmp[0]->order_capacity) <= 10 && ($currentWeight + $ordersTmp[0]->order_comment) <= 3500) {
						$route[] = $ordersTmp[0]->order_id;
						$routes[] = $route;
						$ordersTmp = [];
					}
					break;
				}


				if (count($route) > 3 || $currentCapacity == 10 || $currentWeight == 3500) {
					break;
				}
				//формируем список заказов для отправки гуглу
				$sortedIndexes = [];
				if ($first) {
					$to = '';
					for ($i = 0; $i < count($ordersTmp); $i++) {
						$to .= $ordersTmp[$i]->order_address . '|';
					}
					$to = str_replace(' ', '+', $to);
					$sortedIndexes = $this->sortByDistance($to, 'Липецк,Московская30');
					$first = false;
				}
				else {
					$order = ORM::factory('order', end($route));
					$to = '';
					for ($i = 0; $i < count($ordersTmp); $i++) {
						$to .= $ordersTmp[$i]->order_address . '|';
					}
					$to = str_replace(' ', '+', $to);
					$from = str_replace(' ', '+', $order->order_address);
					$sortedIndexes = $this->sortByDistance($to, $from);
				}

				for ($i = 0; $i < count($sortedIndexes); $i++) {
					if ((($currentCapacity + $ordersTmp[$sortedIndexes[$i]]->order_capacity) > 10) || ($currentWeight + $ordersTmp[$sortedIndexes[$i]]->order_comment > 3500)) {
						continue;
					}
					else {
						$route[] = $ordersTmp[$sortedIndexes[$i]]->order_id;
						$currentCapacity += $ordersTmp[$sortedIndexes[$i]]->order_capacity;
						$currentWeight += $ordersTmp[$sortedIndexes[$i]]->order_comment;
						unset($ordersTmp[$sortedIndexes[$i]]);
						$ordersTmp = array_values($ordersTmp);
						break;
					}
				}

				if (count($route) == 0) {
					break;
				}
			}


			if (count($orders) != 0 && count($route) != 0) {
				$orders = [];
				$newRoute = ORM::factory('route');
				$newRoute->route_date = $date;
				$newRoute->save();
				foreach ($route as $id) {
					$order = ORM::factory('order', $id);
					$order->order_route = 1;
					$order->save();

					$newWaypoint = ORM::factory('waypoint');
					$newWaypoint->route_id = $newRoute->route_id;
					$newWaypoint->order_id = $order->order_id;
					$newWaypoint->waypoint_address = $order->order_address;
					$newWaypoint->save();

					$tmpOrder = [
						'id' => $order->order_id,
						'place' => $order->order_address,
						'coordinates' => $order->order_coordinates,
						'capacity' => $order->order_capacity,
						'weight' => $order->order_comment,
						'cost' => $order->order_cost
					];
					if ($order->client_id) {
						$tmpOrder['mobile'] = $order->client->client_mobile;
						$tmpOrder['name'] = $order->client->client_name;
					}
					else {
						$tmpOrder['mobile'] = $order->user->phone;
						$tmpOrder['name'] = $order->user->fio;
					}
					$orders[] = $tmpOrder;
	 			}
				array_unshift($orders, ['id' => '-1', 'place' => 'Липецк,Московская30', 'coordinates' => '52.6014879,39.5046515']);
			}
			else {
				$orders = [];
			}


			$points = [];
			for ($i = 0; $i < count($ordersTmp); $i++) {
				$tmpOrder = [
					'id' => $ordersTmp[$i]->order_id,
					'place' => $ordersTmp[$i]->order_address,
					'coordinates' => $ordersTmp[$i]->order_coordinates,
					'capacity' => $ordersTmp[$i]->order_capacity,
					'weight' => $ordersTmp[$i]->order_comment,
					'cost' => $ordersTmp[$i]->order_cost
				];
				if ($ordersTmp[$i]->client_id) {
					$tmpOrder['mobile'] = $ordersTmp[$i]->client->client_mobile;
					$tmpOrder['name'] = $ordersTmp[$i]->client->client_name;
				}
				else {
					$tmpOrder['mobile'] = $ordersTmp[$i]->user->phone;
					$tmpOrder['name'] = $ordersTmp[$i]->user->fio;
				}
				$points[] = $tmpOrder;
			}
			$result = ['routes' => $orders, 'orders' => $points, 'readyroutes' => $readyRoutes];
		 	echo json_encode($result, JSON_UNESCAPED_UNICODE);
			return;
		}

		public function action_saveroute() {

		}

		private function checkDistance($to, $from='Липецк,Московская+30') {
			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?language=ru&origins=$from&destinations=$to&key=AIzaSyA9gsVFdzQj3RXFdFei7-LpdOuzjR4-VkU";
			// echo $url;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
			curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
			curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
			$content = curl_exec( $ch );
			curl_close( $ch );
			// echo $content;
			// echo '<br><hr>';
			return $content;
		}

		public function sortByDistance($to, $from) {
			$response = $this->checkDistance($to, $from);
			$response = json_decode($response, TRUE);

			$indexes = range(0, count($response['rows'][0]['elements']) - 1);
			// for ($i = 0; $i < count($response['rows'][0]['elements']); $i++) {}
			for ($i = 0; $i < count($indexes); $i++) {
				for ($j = $i + 1; $j < count($indexes); $j++) {
						if ($response['rows'][0]['elements'][$indexes[$i]]['distance']['value'] > $response['rows'][0]['elements'][$indexes[$j]]['distance']['value']) {
							$tmp = $indexes[$j];
							$indexes[$j] = $indexes[$i];
							$indexes[$i] = $tmp;
						}
				}
			}
			return $indexes;
		}

		/*private function getNearestPoint($to, $from='Липецка,Московская') {
			$response = checkDistance($to, $from);
			$response = json_decode($response, TRUE);

			$currentMin = PHP_INT_MAX;
			$index = 0;
			for ($i = 0; $i < count($response['rows']['elements'])) {
				if ($response['rows']['elements'][$i]['distance']['value'] < $currentMin) {
					$currentMin = $response['rows']['elements'][$i]['distance']['value'];
					$index = $i;
				}
			}
			return $index;
		}*/

		private function minDistance($array) {
			$currentMin = PHP_INT_MAX;
			$index = 0;
			for ($i = 0; $i < count($array); $i++) {
				if ($array[$i]['distance'] < $currentMin) {
					$currentMin = $array[$i]['distance'];
					$index = $i;
				}
			}
			return $index;
		}

		public function before() {

		}
		public function after() {
			$this->response->headers('Access-Control-Allow-Origin','*');
			$this->response->headers('Access-Control-Allow-Methods','*');
			$this->response->headers('Content-Type','application/json;charset=utf-8');
			parent::after();
		}
}
