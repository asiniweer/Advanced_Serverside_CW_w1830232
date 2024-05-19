<?php
require APPPATH . 'libraries/REST_Controller.php';

class Post extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Post_model');
        $this->load->helper(['url', 'file']);
    }

    // load view of dashboard 
    public function dashboard_get() {
        $posts = $this->Post_model->get_all_posts();
        $this->load->view('dashboard', ['posts' => $posts]);
    }

    // load view of create post
    public function createPost_get() {
        if (!$this->session->userdata('id')) {
            redirect('auth/login');
        }
        $this->load->view('create_post');
    }

    // Fetch all posts
    public function index_get() {
        $posts = $this->Post_model->get_all_posts();

        if ($posts) {
            // Respond with all posts
            $this->response($posts, REST_Controller::HTTP_OK);
        } else {
            $this->response(['message' => 'No posts found'], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // load post view
    public function view_get($post_id = NULL) {
        if ($post_id === NULL) {
            $this->response(['message' => 'No post ID provided'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $post = $this->Post_model->get_post($post_id);
        if ($post) {
            
            $this->load->view('post_view', ['post' => $post]);
        } else {
            $this->response(['message' => 'Post not found'], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // add post 
    public function createPost_post() {
        $config['upload_path'] = './upload_images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 5242880; // 5 MB
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('image')) {
            $this->response([
                'status' => FALSE,
                'message' => $this->upload->display_errors()
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $file_data = $this->upload->data();
            $image_content = file_get_contents($file_data['full_path']);
            $data = [
                'user_id' => $this->session->userdata('id'),
                'image' => base64_encode($image_content),
                'caption' => $this->post('caption'),
                'description' => $this->post('description')
            ];
    
            if ($this->Post_model->insert_post($data)) {
                $this->response(['message' => 'Post created successfully'], REST_Controller::HTTP_OK);
            } else {
                $this->response(['message' => 'Failed to create post'], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    
        @unlink($file_data['full_path']); // Optional: delete file after upload
    }

    //find post by caption
    public function getPostIdByCaption_get() {
        $caption = $this->input->get('caption');
        $this->load->model('Post_model');
        $post = $this->Post_model->get_post_by_caption($caption);

        if ($post) {
            echo json_encode(['post_id' => $post['id']]);
        } else {
            echo json_encode(['post_id' => null]);
        }
    }

    //find posts list by caption first name or letter
    public function getPostCaptionsByQuery_get() {
        $query = $this->input->get('query');
        $this->load->model('Post_model');
        $posts = $this->Post_model->get_post_captions_by_query($query);
    
        if ($posts) {
            echo json_encode($posts);
        } else {
            echo json_encode([]);
        }
    }

    // search post by keyword and return comments as well
    public function search_get() {
        $query = $this->input->get('query');
        if (!$query) {
            $this->response(['message' => 'No query provided'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
    
        $posts = $this->Post_model->get_posts_by_keyword($query);
        if ($posts) {
            foreach ($posts as &$post) {
                $post['comments'] = $this->Post_model->get_comments_by_post_id($post['id']);
            }
            $this->response($posts, REST_Controller::HTTP_OK);
        } else {
            $this->response(['message' => 'No posts found'], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // like post
    public function like_post($post_id) {
        $user_id = $this->session->userdata('id'); 
        if (!$user_id) {
            $response = ['status' => false, 'message' => 'User not logged in'];
        } elseif ($post_id) {
            $reaction_result = $this->Post_model->add_reaction($post_id, $user_id, 'like');
            if ($reaction_result) {
                $response = ['status' => true, 'message' => 'Post liked successfully', 'counts' => $reaction_result];
            } else {
                $response = ['status' => false, 'message' => 'Failed to like post or already liked'];
            }
        } else {
            $response = ['status' => false, 'message' => 'Invalid post ID'];
        }
    
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    // dislike post
    public function dislike_post($post_id) {
        $user_id = $this->session->userdata('id');
        if (!$user_id) {
            $response = ['status' => false, 'message' => 'User not logged in'];
        } elseif ($post_id) {
            $counts = $this->Post_model->add_reaction($post_id, $user_id, 'dislike');
            if ($counts) {
                $response = ['status' => true, 'message' => 'Post disliked successfully', 'counts' => $counts];
            } else {
                $response = ['status' => false, 'message' => 'Failed to dislike post'];
            }
        } else {
            $response = ['status' => false, 'message' => 'Invalid post ID'];
        }
    
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    } 
}
