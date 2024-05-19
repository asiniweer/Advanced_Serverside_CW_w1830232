<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // insert comment into comments table
    public function insert_comment($data) {
        return $this->db->insert('comments', $data);
    }

    // get comments by post id
    public function get_comments_by_post($post_id) {
        $this->db->select('comments.*, user.user_name'); // Select fields from comments and username from users table
        $this->db->from('comments');
        $this->db->join('user', 'user.user_id = comments.user_id'); // Join users table
        $this->db->where('comments.post_id', $post_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
