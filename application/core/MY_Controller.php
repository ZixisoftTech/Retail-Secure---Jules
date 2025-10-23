<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller
 *
 * This controller serves as the base for all other controllers in the application.
 * It handles common functionalities like authentication checks and template loading.
 *
 * @package     CodeIgniter
 * @subpackage  Core
 * @category    Controller
 * @author      Jules
 */
class MY_Controller extends CI_Controller {

    /**
     * User data for the currently logged-in user.
     * @var object
     */
    protected $user_data;

    /**
     * Constructor
     *
     * Loads dependencies and verifies user authentication.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // Verify user is logged in, except for the auth controller
        if (strtolower($this->router->fetch_class()) !== 'auth') {
            $this->verify_login();
        }
    }

    /**
     * Verify Login
     *
     * Checks if a user is logged in. If not, redirects to the login page.
     * Stores the user data if the user is authenticated.
     */
    protected function verify_login()
    {
        if ( ! $this->session->userdata('is_logged_in')) {
            // Redirect to the login page if not logged in
            redirect('auth/login');
        } else {
            // Store user data for easy access in child controllers
            $this->user_data = $this->session->userdata();
        }
    }

    /**
     * Load View
     *
     * Loads the main application template, including header, sidebar, footer,
     * and the main content view.
     *
     * @param   string  $view   The main content view to load.
     * @param   array   $data   Data to pass to the views.
     */
    protected function load_view($view, $data = [])
    {
        // Load the template parts
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view($view, $data); // Main content
        $this->load->view('templates/footer', $data);
    }
}
