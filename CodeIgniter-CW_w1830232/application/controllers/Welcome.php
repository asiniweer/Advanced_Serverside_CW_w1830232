<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Welcome extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    // Redirect to User/login endpoint
    public function index_get() {
        
        $this->response(['message' => 'Redirecting to User/login endpoint'], REST_Controller::HTTP_MOVED_PERMANENTLY);
        redirect('Auth/login');
    }

}
