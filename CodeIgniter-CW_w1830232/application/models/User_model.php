<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	// Store user data into the database
	public function store($data) {
		$this->db->insert('user', $data);
		return true;
	}

    // Get user data by username
    public function getUser($username) {
        return $this->db->where('user_name', $username)->get('user')->row();
    }
}
?>
