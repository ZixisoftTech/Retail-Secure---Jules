<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard Model
 *
 * This model handles database operations for fetching dashboard statistics.
 *
 * @package     CodeIgniter
 * @subpackage  Models
 * @category    Model
 * @author      Jules
 */
class Dashboard_model extends CI_Model {

    /**
     * Constructor
     *
     * Loads the database library.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get Dashboard Stats
     *
     * Fetches all the required counts for the dashboard cards.
     *
     * @return  array   An associative array of statistics.
     */
    public function get_dashboard_stats()
    {
        // Initialize stats array
        $stats = [
            'total_packages' => 0,
            'total_admins' => 0,
            'total_super_stockists' => 0,
            'total_distributors' => 0,
            'total_retailers' => 0,
            'active_device_users' => 0,
            'todays_activations' => 0,
        ];

        // Get total packages
        $stats['total_packages'] = $this->db->count_all('packages');

        // Get user counts by role
        $this->db->select('role, COUNT(id) as count');
        $this->db->from('users');
        $this->db->group_by('role');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            switch ($row->role) {
                case 'admin':
                    $stats['total_admins'] = $row->count;
                    break;
                case 'super_stockist':
                    $stats['total_super_stockists'] = $row->count;
                    break;
                case 'distributor':
                    $stats['total_distributors'] = $row->count;
                    break;
                case 'retailer':
                    $stats['total_retailers'] = $row->count;
                    break;
            }
        }

        // Get active device users
        $this->db->where('status', 'active');
        $stats['active_device_users'] = $this->db->count_all_results('devices');

        // Get today's activations
        $this->db->where('DATE(activated_at)', 'CURDATE()', FALSE);
        $stats['todays_activations'] = $this->db->count_all_results('devices');

        return $stats;
    }
}
