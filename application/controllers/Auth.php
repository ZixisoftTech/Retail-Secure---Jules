<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Controller
 *
 * Handles user authentication, including login and logout.
 *
 * @package     CodeIgniter
 * @subpackage  Controllers
 * @category    Controller
 * @author      Jules
 */
class Auth extends CI_Controller {

    /**
     * Constructor
     *
     * Loads necessary libraries and models.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper('url');
        $this->load->model('User_model');
    }

    /**
     * Login
     *
     * Displays the login page and handles the login form submission.
     */
    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->session->userdata('is_logged_in')) {
            redirect('dashboard');
        }

        // Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails, show the login page again
            $this->load->view('auth/login');
        } else {
            // On successful validation, authenticate the user
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->get_user_by_email($email);

            // Verify user and password
            if ($user && password_verify($password, $user->password)) {
                // Set session data
                $session_data = [
                    'user_id'       => $user->id,
                    'full_name'     => $user->full_name,
                    'email'         => $user->email,
                    'role'          => $user->role,
                    'is_logged_in'  => TRUE
                ];
                $this->session->set_userdata($session_data);

                // Redirect to the dashboard
                redirect('dashboard');
            } else {
                // If login fails, set a flash message and redirect back to login
                $this->session->set_flashdata('error', 'Invalid email or password.');
                redirect('auth/login');
            }
        }
    }

    /**
     * Logout
     *
     * Destroys the user session and redirects to the login page.
     */
    public function logout()
    {
        // Destroy the session and redirect
        $this->session->sess_destroy();
        redirect('auth/login');
    }

}
