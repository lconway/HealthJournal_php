<?php

class Food_model extends CI_Model
{
	public function create_food($food)
	{
		return $this->db->insert("foods", $food);
	}

	public function get_categories()
	{
		$query = $this->db->get('categories');
		return $query->result();
		
	}
	
	public function get_measurements()
	{
		$query = $this->db->get('measurements');
		return $query->result();
	}
	
	public function get_meals()
	{
		$query = $this->db->get('meals');
		return $query->result_array();
	}
	
	public function get_foods()
	{
		$this->db->select('name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('foods');
		return $query->result_array();
	}
	
	public function get_myFoods()
	{
		$query = $this->db->query( 
				"select foods.name
				from foods
				join userFoods on userFoods.food_id = foods.id
				order by foods.name asc;"
				);
		return $query->result_array();
	}

	public function get_foods_by_date($meal_id)
	{
		//$date = date('Y-m-d', time());
		$date = new DateTime($this->session->userdata('journal_date'));
		$date = $date->format('Y-m-d') . "%";
		//echo "Get foods by date " . $date . "<br>";
		// $date = new DateTime('2013-09-05');
		// $date = $date->format('Y-m-d') . "%";
		// echo "Get foods by date " . $date . "<br>";
		$query = $this->db->query( 
				"select f.id as foodid, f.name as foodName, m.name as measureName, f.serving_size, f.calories, f.carbs, f.fat, f.protein, f.sodium, f.sugar 
				from users u
				join userMeals um on um.user_id = u.id
				join itemsPerMeal ipm on ipm.userMeal_id = um.id
				join foods f on ipm.food_id = f.id
				join measurements m on m.id = f.measurement_id
				where u.id = '{$this->session->userdata('user_id')}' 
				and um.day_and_time  like '{$date}' 
				and um.meal_id = '{$meal_id}';"
				);
		//	and um.day_and_time  >= '2013-09-05 00:00:00' and um.day_and_time < '2013-09-06 00:00:00' 
		// $rows = $query->result();
		// echo "<br>";
		// echo "list foods<br>";
		// foreach($rows as $row)
		// {
		// 	echo $row->foodName." ".$row->serving_size." ".$row->measureName." ".$row->calories."<br>";
		// }
		return $query->result_array();
	}

	public function get_food_name_by_id($food_name)
	{
		$this->db->where('name', $name);
		$this->db->select('id');
		$this->db->get('foods');
	}

	public function get_food_id_by_name($food_id)
	{
		$this->db->where('id', $food_id);
		$this->db->select('name');
		$this->db->get('foods');
	}

	public function add_myFoods($foods)
	{
		$setWhere = false;
		foreach ($foods as $food)
		{
			if (!$setWhere) 
			{
				$setWhere = true;
				$this->db->where('name', $food);
			} else
			{
				$this->db->or_where('name', $food);
			}
		}
		$this->db->select('id');
		$query = $this->db->get('foods');

		foreach ($query->result() as $row)
		{
			$data = array(
				'user_id' => $this->session->userdata('user_id'),
				'food_id' => $row->id
			);
			$this->db->insert('userFoods', $data);
		}
	}

	public function add_toMeal($mealInfo)
	{
		// echo "In add_toMeal<br>";
		// echo "<pre>";
		// var_dump($mealInfo);
		// echo "</pre>";
		//Get food id from food name
		$setWhere = false;
		foreach ($mealInfo['foods'] as $food)
		{
			if (!$setWhere) 
			{
				$setWhere = true;
				$this->db->where('name', $food);
			} else
			{
				$this->db->or_where('name', $food);
			}
		}
		$this->db->select('id');
		$query = $this->db->get('foods');
		if ($query->num_rows() <= 0) {
			//echo "<br>No rows!!<br>";		// didn't get any food ids
		} else
		{
			//echo "<br>got some rows!!<br>";
			$foodIds = $query->result();
			//echo "<br>";
			//echo "list food ids<br>";
			foreach($foodIds as $row)
			{
				//echo $row->id . "<br>";
			}
			// If this meal for this user already exist in userMeals table,
			//   don't recreate it.
			$date = date('Y-m-d', time());
			//echo "<br>date is " . $date . "<br>";
			$this->db->where('user_id', $this->session->userdata('user_id'));
			$this->db->where('meal_id', $mealInfo['mealId']);
			$this->db->where('day_and_time', $date);
			$this->db->select('id');
			$query = NULL;
			$query = $this->db->get('userMeals');

			if ($query->num_rows() <= 0) {  
				// Add new user/meal record for userMeal table  
				//echo "No rows is ok!";
				$data = array(
					'user_id' => $this->session->userdata('user_id'),
					'meal_id' => $mealInfo['mealId'],
					'day_and_time' => $date,
					'created_at' => $date
					);
				$this->db->insert('userMeals', $data);
				$userMeal_id = $this->db->insert_id();
				//echo "<br>userMeal_id is " . $userMeal_id . "<br>";
			} else
			{
				// this meal for this user already exist in userMeal table
				//echo "<br>user meal already exists!!<br>";
// left off here
				$userMeal_id = $mealInfo['mealId'];
				$rows = $query->result();
				//echo "<br>";
				//echo "userMeal id is <br>" . $mealInfo['mealId'] . "<br>";
			}
			// Add food for this meal to itemsPerMeal table
				// $data = array(
				// 	'user_id' => $this->session->userdata('user_id'),
				// 	'meal_id' => $mealInfo['mealId'],
				// 	'day_and_time' => $date,
				// 	'created_at' => $date
				// 	);
				// $this->db->insert('userMeals', $data);

		}
		//echo "userMeal id is <br>" . $mealInfo['mealId'] . "<br>";
		foreach($foodIds as $foodId)
		{
			// $foodId->id . "<br>";
			$data = array(
				// Add user_id to itemsPerTable when there is more than 1 user
				//'user_id' => $this->session->userdata('user_id'),
				'food_id' => $foodId->id,
				'userMeal_id' => $userMeal_id,
				'created_at' => $date
			);
			$this->db->insert('itemsPerMeal', $data);
		}
	}
		
	public function delete_foods($foods)
	{
		// echo "In delete_foods";
		// echo "<pre>";
		// var_dump($foods);
		// echo "</pre>";
		$setWhere = false;
		foreach ($foods as $food)
		{
		// echo "<pre>";
		// var_dump($food);
		// echo "</pre>";
			if (!$setWhere) 
			{
				$setWhere = true;
				$this->db->where('name', $food);
			} else
			{
				$this->db->or_where('name', $food);
			}
		}
		$this->db->delete('foods');
	}

	public function delete_myFoods($foods)
	{
		foreach ($foods as $food)
		{
			$query = $this->db->query( 
					"delete userFoods
					from userFoods
					join foods on foods.id = userFoods.food_id
					where foods.name = '{$food}';"
					);
		}
		$query;
	}
}
