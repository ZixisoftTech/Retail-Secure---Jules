<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Controller
 *
 * This controller handles the main dashboard page after login.
 *
 * @package     CodeIgniter
 * @subpackage  Controllers
 * @category    Controller
 * @author      Jules
 */
class Dashboard extends MY_Controller {

    /**
     * Index
     *
     * Displays the main dashboard view.
     */
    public function index()
    {
        // Data to be passed to the view
        $data['title'] = 'Dashboard';

        // Load the dashboard view through the base controller's template
        $this->load_view('dashboard', $data);
    }
}
