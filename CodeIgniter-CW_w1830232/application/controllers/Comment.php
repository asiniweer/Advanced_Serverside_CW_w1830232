<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

class Comment extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Comment_model');
        $this->load->model('Post_model'); // Ensure the Post model is loaded
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation']);
    }

    // load the comments and add comment view for a specific post
    public function postComments_get($post_id = NULL) {
        if ($post_id === NULL) {
            show_error('No post ID provided', 400);
            return;
        }

        $post = $this->Post_model->get_post($post_id);
        if (!$post) {
            show_error('Post not found', 404);
            return;
        }

        $comments = $this->Comment_model->get_comments_by_post($post_id);
        $data['post'] = $post;
        $data['comments'] = $comments;
        $data['post_id'] = $post_id;
        $this->load->view('comments', $data);
    }

    // Handle the add comment form submission
    public function addComment_post($post_id = NULL) {
        if ($post_id === NULL) {
            show_error('No post ID provided', 400);
            return;
        }

   
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['message' => validation_errors()]);
            return;
        }

        $data = [
            'post_id' => $post_id,
            'user_id' => $this->session->userdata('id'),
            'content' => $this->input->post('content'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Comment_model->insert_comment($data)) {
            echo json_encode(['message' => 'Comment added successfully']);
        } else {
            echo json_encode(['message' => 'Failed to add comment']);
        }
    }
}
?>
