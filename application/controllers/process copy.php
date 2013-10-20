<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Process extends CI_Controller {

	public $username;
	public $viewData = array();
	public $modelData = array();

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		echo "This is the default page<br>";
	}

	public function login()
	{
		$this->load->view('login');
	}

	public function journal()
	{
		$this->load->model('Food_model');
		$meals = $this->Food_model->get_meals();
		//$viewData['meals'] = $meals;
		// echo "<pre>";
		// var_dump($meals);
		// echo "</pre>";
		$viewData['meals'] = array();
		$i=0;

		foreach ($meals as $meal)
		{
			

			array_push($viewData['meals'], $meal);
			// $viewData=array();


			// var_dump($viewData[0]->id);

			

			// $viewData = array($meal);
				
			$myMeals = $this->Food_model->get_foods_by_date($meal['id']);
			
			
			$viewData['meals'][$i]['items'] = array();
			// var_dump($viewData['meals']['items']); 

			foreach($myMeals as $myMeal => $hello)
			 {
			 	array_push($viewData['meals'][$i]['items'], $hello);
			 }
			 $i++;
		}
				// echo "<br>";
				// echo "IN VIEWDATA <br>";
				// echo "<pre>";
				// var_dump($viewData);
				// echo "</pre>";

		//$viewData['foods'] = $foods;
		$this->load->view('journal', $viewData);
	}

	public function add()
	{
		$this->load->view('foods');
	}

	public function foods()
	{
		$this->load->model('Food_model');
		$foods = $this->Food_model->get_foods();
		$viewData['foods'] = $foods;
		$userFoods = $this->Food_model->get_myFoods();
		$viewData['myFoods'] = $userFoods;

		$this->load->view('foods', $viewData);
	}

	public function create()
	{
		$this->load->model('Food_model');
		$measurements = $this->Food_model->get_measurements();
		$viewData['measurements'] = $measurements;
		
		$categories = $this->Food_model->get_categories();
		$viewData['categories'] = $categories;
		
		// $measurements = $this->Food_model->get_measurements();
		// $viewData['foods'] = $measurements;

		$this->load->view('entry', $viewData);
	}

	public function logout() 
	{
		$this->session->sess_destroy();
		redirect(base_url('/process/login'));
	}

	public function process_login()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules('email', 'Email Address', 'valid_email|required');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required');

		if ($this->form_validation->run() === FALSE)
		{
			echo validation_errors();
		} else 
		{
			$this->load->library("form_validation");
			$this->load->library('encrypt');

			$this->modelData['user'] = array(
				'email' => $this->input->post('email'),
				'password' => $this->encrypt->encode($this->input->post('password'))
			);

			$this->load->model('User_model');
			$user = $this->User_model->get_user($this->modelData['user']);
			//echo "userid = " . $user->id . "<br>";
			$this->session->set_userdata('user_id', $user->id);
			redirect(base_url('/process/journal'));
		}
	}
	public function process_register()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules('firstname', 'First Name', 'alpha_numeric|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'alpha_numeric|required');
		$this->form_validation->set_rules('email', 'Email Address', 'valid_email|required');
			//|matches['confirm_password']');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|required');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			echo validation_errors();
		} else
		{
			echo "register user <br>";
			$date = date('Y-m-d H:i:s', time());
			$this->load->library('encrypt');
			$this->modelData['user'] = array(
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'password' => $this->encrypt->encode($this->input->post('password')),
				'created_at' => $date
			);
			$this->load->model('User_model');
			$user = $this->User_model->register_user($this->modelData['user']);
			redirect(base_url('/process/journal'));
		}

	}

	public function process_create()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules('foodName', 'Food Name or Description', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			echo validation_errors();
		} else
		{
			$date = date('Y-m-d', time());
			$this->modelData['food'] = array(
				'name' => $this->input->post('foodName'),
				'category_id' => $this->input->post('category'),
				'serving_size' => $this->input->post('serveSize'),
				'measurement_id' => $this->input->post('measurement'),
				'serv_per_container' => $this->input->post('perContainer'),
				'calories' => $this->input->post('calories'),
				'carbs' => $this->input->post('carbs'),
				'fat' => $this->input->post('fats'),
				'protein' => $this->input->post('protein'),
				'sodium' => $this->input->post('sodium'),
				'sugar' => $this->input->post('sugar'),
				'created_at' => $date
			);

			$this->load->model('Food_model');
			$user = $this->Food_model->create_food($this->modelData['food']);

			$this->load->view('journal');
		}
	}

	public function food_actions()
	{
		// echo "<pre>";
		// var_dump($this->input->post());
		// echo "</pre>";
		if ($this->input->post('action') == "Add To My Foods")
		{
			$this->load->model('Food_model');
			$this->modelData['food'] = $this->input->post('allFoods');
			$this->Food_model->add_myFoods($this->modelData['food']);
			redirect(base_url('/process/foods'));
		} else if  ($this->input->post('action') == "Delete From Foods")
		{
			$this->load->model('Food_model');
			$this->modelData['food'] = $this->input->post('allFoods');
			redirect(base_url('/process/foods'));
			$this->Food_model->delete_foods($this->modelData['food']);
		} else if  ($this->input->post('action') == "Delete From My Foods")
		{
			$this->load->model('Food_model');
			$this->modelData['food'] = $this->input->post('myFoods');
			$this->Food_model->delete_myFoods($this->modelData['food']);
			redirect(base_url('/process/foods'));
		} else if  ($this->input->post('action') == "createNewFood")
		{
			redirect(base_url('/process/create'));
		}
	}
}