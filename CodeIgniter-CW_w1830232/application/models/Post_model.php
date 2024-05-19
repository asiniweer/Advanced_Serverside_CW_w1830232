<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Add a reaction to a post
    public function add_reaction($post_id, $user_id, $reaction) {
        $this->db->where(['post_id' => $post_id, 'user_id' => $user_id]);
        $existing_reaction = $this->db->get('reactions')->row();
    
        if ($existing_reaction) {
            if ($existing_reaction->reaction === $reaction) {
                return false;
            } else {
                $this->db->where('id', $existing_reaction->id);
                $this->db->update('reactions', ['reaction' => $reaction]);
                return $this->_update_post_reaction_count($post_id);
            }
        } else {
            $this->db->insert('reactions', ['post_id' => $post_id, 'user_id' => $user_id, 'reaction' => $reaction]);
            return $this->_update_post_reaction_count($post_id);
        }
    }
    
    // Update the post's like and dislike counts
    private function _update_post_reaction_count($post_id) {
        
        $this->db->select('reaction, COUNT(*) as count');
        $this->db->where('post_id', $post_id);
        $this->db->group_by('reaction');
        $reactions = $this->db->get('reactions')->result();
    
        $likes = 0;
        $dislikes = 0;
        foreach ($reactions as $reaction) {
            if ($reaction->reaction === 'like') {
                $likes = $reaction->count;
            } elseif ($reaction->reaction === 'dislike') {
                $dislikes = $reaction->count;
            }
        }
    
        $this->db->where('id', $post_id);
        $this->db->update('posts', ['likes' => $likes, 'dislikes' => $dislikes]);
    
        return ['likes' => $likes, 'dislikes' => $dislikes];
    }
    

    // Insert a post into the posts table
    public function insert_post($data) {
        return $this->db->insert('posts', $data);
    }

    // Delete a post by post ID
    public function delete_post($post_id) {
        return $this->db->delete('posts', array('id' => $post_id));
    }

    // Get all posts, sorted by the latest post
    public function get_all_posts() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('posts')->result_array();
    }

    // Get a post by post ID
    public function get_post($post_id) {
        $this->db->select('posts.*, 
                           (SELECT COUNT(*) FROM reactions WHERE reactions.post_id = posts.id AND reactions.reaction = "like") as likes, 
                           (SELECT COUNT(*) FROM reactions WHERE reactions.post_id = posts.id AND reactions.reaction = "dislike") as dislikes');
        $this->db->from('posts');
        $this->db->where('posts.id', $post_id);
        $query = $this->db->get();

        return $query->row_array();
    }

    // Get a post by caption
    public function get_post_by_caption($caption) {
        $this->db->like('caption', $caption);
        $query = $this->db->get('posts');
        return $query->row_array();
    }

    // Get comments by post ID
    public function get_comments_by_post_id($post_id) {
        $this->db->where('post_id', $post_id);
        $query = $this->db->get('comments');
        return $query->result_array();
    }
    
    // Get posts by keyword -query   
    public function get_post_captions_by_query($query) {
        $this->db->like('caption', $query, 'after'); // 'after' ensures it matches from the beginning of the string
        $this->db->select('id, caption'); // Select only id and caption
        $query = $this->db->get('posts');
        return $query->result_array();
    }

    // Get posts by caption
    public function get_posts_by_keyword($keyword) {
        $this->db->like('caption', $keyword);
        $query = $this->db->get('posts');
        return $query->result_array();
    }
    
}
?>
