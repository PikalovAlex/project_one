<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page extends Controller_Common {

       public $template = 'main';
 
    public function action_index()
    {	
	if(Auth::instance()->logged_in())
		{
		$user = Auth::instance()->get_user();
		$content = View::factory('formain', array('username' => $user));	
		$this->template->content = $content;
        $content1 = View::factory('welcome');
        $this->template->title = 'Аис логистики грузоперевозок';
        $this->template->description = '20.05.2018 11:08';
        $this->template->content .= $content1;
		}
		else
		{
		$content = View::factory('forma');	
		$this->template->content = $content;
        $content1 = View::factory('welcome');
        $this->template->title = 'Аис логистики грузоперевозок';
        $this->template->description = '20.05.2018 11:08';
        $this->template->content .= $content1;
		}
    }
	
	 public function action_price()
    {
		if(Auth::instance()->logged_in())
		{
		$user = Auth::instance()->get_user();
		$content = View::factory('formain', array('username' => $user));	
		$this->template->content = $content;	
        $content1 = View::factory('/pages/price');
        $this->template->title = 'Price';
        $this->template->description = 'Прайс лист 12.05.2018';
        $this->template->content .= $content1;
		}
		else
		{
			$content = View::factory('forma');	
			$this->template->content = $content;
			$content1 = View::factory('/pages/price');
			$this->template->title = 'Price';
			$this->template->description = 'Прайс лист 12.05.2018';
			$this->template->content .= $content1;
		}
    }
	
	
	 public function action_registration()
    {
		$content = View::factory('forma');
		$this->template->content = $content;	
        $content1 = View::factory('/pages/registration');
        $this->template->title = 'Регистрация пользователей';
        $this->template->description = '13.05.2018 11:52';
        $this->template->content .= $content1;
    }
	
	 public function action_mainclient()
    {
		if (!Auth::instance()->logged_in('login'))
		{
	//throw new HTTP_Exception_403('403');
			$this->redirect('/');
			return;
		}
		else{
		$user = Auth::instance()->get_user();
		$content = View::factory('formain', array('username' => $user));
		$this->template->content = $content;
        $content1 = View::factory('/pages/mainclient');
        $this->template->description = '20.05.2018 15:58';
        $this->template->content .= $content1;
		}
    }
	
	public function action_userAdd()
	{	
		if ( $_POST)
		{
			$_POST = Arr::map('trim', $_POST);
			//var_dump($_POST);
			$post = Validation::factory($_POST);
		  $post -> rule('username', 'not_empty')  
				-> rule('password1', 'not_empty')
				-> rule('password2', 'not_empty')
				-> rule('email', 'not_empty')
				->rule('email', 'email')
				-> rule('fio', 'not_empty')
				-> rule('submit', 'not_empty')
				-> rule('phone', 'not_empty')
				->rule('password2', 'matches', array(':validation', 'password2', 'password1'))
				->rule('password1', 'min_length', array(':value', 8))
				->rule('password2', 'min_length', array(':value', 8));
	  
	/* можно переделать если время будет*/
			 $Username = $this->request->post('username');
			 $Password1 = $this->request->post('password1');
			 $Password2 = $this->request->post('password2');
			 $Email = $this->request->post('email');
			 $FIO = $this->request->post('fio');
			 $Phone = $this->request->post('phone');
			
			if($post->check())
				{
				$user = ORM::factory('user')
				->create_user(array('username' => $Username, 'email' => $Email, 'password' => $Password1, 'password_confirm' => $Password2), array('username', 'email', 'password'))
				->add('roles', ORM::factory('role', array('name' => 'login')))
				->set('fio', $FIO)
				->set('phone', $Phone)
				->save();
						$content = View::factory('forma');
						$this->template->content = $content;	 
						$content1 = View::factory('welcome');
						$this->template->content .= $content1;
			}
			else
			{ 
			
		    $errors = $post -> errors('validation');
			$content = View::factory('forma');
			$this->template->content = $content;
			$content1 = View::factory('/pages/registration', array('errors' => $errors));
			$this->template->content .= $content1;
			//print_r($post->errors('validation'));
			}
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
					$user = Auth::instance()->get_user();
					$content = View::factory('formain', array('username' => $user));
					$this->template->content = $content;
					$content1 = View::factory('/pages/mainclient');
					$this->template->content .= $content1;
				}
				else
				{		
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