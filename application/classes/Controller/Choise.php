<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Choise extends Controller_Common {

       public $template = 'main';

	 public function action_concrete()
    {
		if(Auth::instance()->logged_in())
		{
		$user = Auth::instance()->get_user();
		$content = View::factory('formain', array('username' => $user));
		$this->template->content = $content;
		$content1 = View::factory('/order/concrete');
        $this->template->title = 'Заказ бетона';
        $this->template->description = '13.05.2018 12:14';
        $this->template->content .= $content1;
		}
		else
		{
		$content = View::factory('forma');
		$this->template->content = $content;
        $content1 = View::factory('/order/concrete');
        $this->template->title = 'Заказ бетона';
        $this->template->description = '13.05.2018 12:14';
        $this->template->content .= $content1;
		}
    }



	 public function action_lease()
    {
        if(Auth::instance()->logged_in())
		{
		$user = Auth::instance()->get_user();
		$content = View::factory('formain', array('username' => $user));
		$content1 = View::factory('/order/lease');
        $this->template->title = 'Аренда авто';
        $this->template->description = '13.05.2018 12:14';
        $this->template->content = $content1;
		}
		else
		{
		$content = View::factory('forma');
        $content1 = View::factory('/order/lease');
        $this->template->title = 'Аренда авто';
        $this->template->description = '13.05.2018 12:14';
        $this->template->content = $content1;
		}
    }

	public function action_sand()
    {
        if(Auth::instance()->logged_in())
		{
		$user = Auth::instance()->get_user();
		$content = View::factory('formain', array('username' => $user));
		$this->template->content = $content;
		$content1 = View::factory('/order/sand');
        $this->template->title = 'Заказ песка';
        $this->template->description = '13.05.2018 12:14';
        $this->template->content .= $content1;
		}
		else
		{
		$content = View::factory('forma');
		$this->template->content = $content;
        $content1 = View::factory('/order/sand');
        $this->template->title = 'Заказ песка';
        $this->template->description = '13.05.2018 12:14';
        $this->template->content .= $content1;
		}
    }

	public function action_main()
	{
		if($_POST)
		{
			$Username = $this->request->post('username');
			$Password = $this->request->post('password');
			$_POST = Arr::map('trim', $_POST);
			//var_dump($_POST);
			$post = Validation::factory($_POST);
			$post -> rule('username', 'not_empty')
				-> rule('password', 'not_empty');
				if (Auth::instance()->login($Username, $Password, TRUE))
				{

					$content = View::factory('formain');
					$this->template->content = $content;
					$content1 = View::factory('welcome');
					$this->template->content .= $content1;
				}
				else
				{
					// Ошибка при авторизации

					if($post->check())
					{

					}
					else
					{

						$errors = $post -> errors('validation');
						$content = View::factory('forma', array('errors' => $errors));
						$this->template->content = $content;
						$content1 = View::factory('welcome');
						$this->template->content .= $content1;
						//print_r($post->errors('validation'));
					}
				}
		}
	}
	public function action_mainin()
	{
		if(Auth::instance()->logout(TRUE, FALSE))
		{
					$content = View::factory('forma');
					$this->template->content = $content;
					$content1 = View::factory('welcome');
					$this->template->content .= $content1;
		}

	}

}
