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
			$this->session->set_userdata('meal_id', -1);
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
			//echo "register user <br>";
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

	public function journal()
	{
		//echo "In Journal<br>";
		// if journal_date is not set, set it to today's date
		if (!$this->session->userdata('journal_date'))
		{
			//echo "date is not set<br>";
			$this->session->set_userdata('journal_date', date('Y-m-d H:i:s', time()));
			//echo "date is set to " . $this->session->userdata('journal_date');
		} else
		{
			//echo "date is set to " . $this->session->userdata('journal_date');
		}
		//echo "<br>";


		$this->load->model('Food_model');
		$meals = $this->Food_model->get_meals();

		$lenMeals = count($meals);
		for ($i = 0; $i < $lenMeals; $i++)
		{
			// add array of foods to each meal
			$mealId = $meals[$i]['id'];
			$meals[$i]['myFoods'] =  $this->Food_model->get_foods_by_date($mealId);
		}
		$viewData['meals'] = $meals;
		// foreach ($meals as $meal)
		// {
		// 	echo "<br> meal is " . $meal['name'] . "<br>";
		// 	foreach ($meal['myFoods'] as $food)
		// 	{
		// 		echo "food is " . $food['foodName'] . "<br>";
		// 	}
		// }

		$this->load->view('journal', $viewData);
	}

	public function set_date()
	{
		// echo "Journal date is";
		// echo $this->input->post('journal_date');
		// echo "In set_date";
		$this->session->set_userdata('journal_date', $this->input->post('journal_date'));
		
		redirect(base_url('/process/journal'));
	}

	public function add()
	{
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

			redirect(base_url('/process/foods'));
			//$this->load->view('journal');
		}
	}

	public function foods($mealId = NULL)
	{
		$viewData['mealId'] = $this->input->post('mealId');
		$this->load->model('Food_model');
		$foods = $this->Food_model->get_foods();
		$viewData['foods'] = $foods;
		$userFoods = $this->Food_model->get_myFoods();
		$viewData['myFoods'] = $userFoods;

		$this->load->view('foods', $viewData);
	}

	public function food_actions()
	{
		// echo "<pre>";
		// var_dump($this->input->post());
		// echo "</pre>";

		if ($this->input->post('action') == "Add To Meal")
		{
			$mealId = $this->input->post('mealId');
			$this->load->model('Food_model');
			if ($this->input->post('listType') == "allFoods")
			{
				$foods = $this->input->post('allFoods');
			} else
			{
				$foods = $this->input->post('myFoods');
			}
			$this->modelData['mealInfo'] = array (
				'foods' => $foods,
				'listType' => $this->input->post('listType'),
				'mealId' => $mealId
			);
		// echo "<pre>";
		// var_dump($this->modelData['mealInfo']);
		// echo "</pre>";
			$this->load->model('Food_model');
			$this->Food_model->add_toMeal($this->modelData['mealInfo']);

			redirect(base_url('/process/journal'));
		} else if  ($this->input->post('action') == "Add To My Foods")
		{
			$this->load->model('Food_model');
			$this->modelData['foods'] = $this->input->post('allFoods');
			$this->Food_model->add_myFoods($this->modelData['foods']);
			redirect(base_url('/process/foods'));
		} else if  ($this->input->post('action') == "Delete From Foods List")
		{
			//echo "Delete From Foods<br>";
			$this->load->model('Food_model');
			$this->modelData['foods'] = $this->input->post('allFoods');
			$this->Food_model->delete_foods($this->modelData['foods']);
			redirect(base_url('/process/foods'));
		} else if  ($this->input->post('action') == "Delete From My Foods List")
		{
			$this->load->model('Food_model');
			$this->modelData['foods'] = $this->input->post('myFoods');
			$this->Food_model->delete_myFoods($this->modelData['foods']);
			redirect(base_url('/process/foods'));
		} else if  ($this->input->post('action') == "createNewFood")
		{
			//redirect(base_url('/process/create'));
			$this->create();
		}
	}
}