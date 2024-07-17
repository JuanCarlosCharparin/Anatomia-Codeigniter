<?php
// application/controllers/Home.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
    {
        // Cargar la vista 'dashboard'
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('admin/dashboard');
        $this->load->view('layouts/footer');
    }

}