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
        // Load the User_model to get user counts
        $this->load->model('User_model');
        $user_counts = $this->User_model->get_user_counts_by_role();

        // Data to be passed to the view
        $data['title'] = 'Dashboard';
        $data['stats'] = [
            'packages' => 0, // Placeholder
            'admins' => $user_counts['admin'],
            'super_stockists' => $user_counts['super_stockist'],
            'distributors' => $user_counts['distributor'],
            'retailers' => $user_counts['retailer'],
            'active_device_users' => 0, // Placeholder
            'todays_activations' => 0, // Placeholder
        ];

        // Load the dashboard view through the base controller's template
        $this->load_view('dashboard', $data);
    }
}
