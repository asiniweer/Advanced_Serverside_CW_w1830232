<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

class Auth extends REST_Controller {

    function __construct() {
        parent::__construct();
        // Load libraries,helper,model and database
        $this->load->database();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // load view of register form
    public function register_get() {
        $this->load->view('register');
    }

    //  submit register form
    public function submitRegister_post() {
        $this->form_validation->set_rules('user_name', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]', array('is_unique' => 'This email address is already registered.'));
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
        } else {
            $data['user_name'] = $this->input->post('user_name');
            $data['email'] = $this->input->post('email');
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $response = $this->user_model->store($data);
            if ($response == true) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Successfully registered',
                    'redirect_url' => base_url('auth/login')
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to register'
                );
            }
        }
        $this->response($response);
    }

    // load view of login form
    public function login_get() {
        if ($this->session->has_userdata('id')) {
            redirect('post/dashboard');
        }
        $this->load->view('login');
    }

    // Method to authenticate user login
    public function submitLogin_post() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($user = $this->user_model->getUser($username)) {
                if (password_verify($password, $user->password)) { 
                    $newdata = array(
                        'user_name' => $user->user_name,
                        'id' => $user->user_id,
                        'logged_in' => TRUE
                    );
                    log_message('info', 'User logged in: ' . $user->user_name);
                    $this->session->set_userdata($newdata);
                    log_message('info', $newdata['user_name'] . ' logged in');
                    redirect('post/dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Invalid password');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'No account exists with this username');
                redirect('auth/login');
            }
        }
    }

    // load view of dashboard page
    public function welcome_page_get() {
        $this->load->view('dashboard');
    }

   
    //logout user -> destroy session and redirect to login page
    public function logout_get() {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('logged_in');
        $this->load->view('login');
    }

    // check if user is logged in
    public function checkLoginStatus_get() {
        $logged_in = $this->session->userdata('logged_in'); // Adjust this based on your session data
        $response = ['logged_in' => $logged_in];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
?>
