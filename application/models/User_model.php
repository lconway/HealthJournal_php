<?php

class User_model extends CI_Model
{
	public function register_user($user)
	{
		$query =  $this->db->query("select *
							 from users 
							 where email = '{$user['email']}'"); 
		if ($query->num_rows() > 0)
		{
			return FALSE;
		} else
		{
			//$this->db->insert("users", $user);
			$query = $this->db->insert("users", $user);
			$output = $this->db->insert_id();
			return $output;
		}

	}

	public function get_user($user)
	{
		$result = $this->db->query("select *
							 from users 
							 where email = '{$user['email']}'"
							 )->row();
		//return $this->input->post('password') == $this->encrypt->decode($result->password);
		$this->load->library('encrypt');
		if ($this->input->post('password') == $this->encrypt->decode($result->password))
		{
			//echo "userid = " . $result->id . "<br>";
			return $result;
		} else
		{
			//echo "login is FALSE" . "<br>";
			return FALSE;
		}
	}
}
