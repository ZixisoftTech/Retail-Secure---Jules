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
        // Load the Dashboard_model to get statistics
        $this->load->model('Dashboard_model');
        $stats = $this->Dashboard_model->get_dashboard_stats();

        // Data to be passed to the view
        $data['title'] = 'Dashboard';
        $data['stats'] = $stats;

        // Load the dashboard view through the base controller's template
        $this->load_view('dashboard', $data);
    }
}
