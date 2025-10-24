<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model
 *
 * This model handles database operations for the `users` table.
 *
 * @package     CodeIgniter
 * @subpackage  Models
 * @category    Model
 * @author      Jules
 */
class User_model extends CI_Model {

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
     * Get User by Email
     *
     * Retrieves a single user from the database based on their email address.
     *
     * @param   string  $email  The email address of the user.
     * @return  object|null     The user object if found, otherwise null.
     */
    public function get_user_by_email($email)
    {
        // Query the database to find the user
        $query = $this->db->get_where('users', ['email' => $email]);

        // Return the user row if it exists
        return $query->row();
    }

    /**
     * Get User Counts by Role
     *
     * Counts the number of users for each role.
     *
     * @return  array   An associative array with roles as keys and counts as values.
     */
    public function get_user_counts_by_role()
    {
        // Select the role and the count of users for each role
        $this->db->select('role, COUNT(id) as count');
        $this->db->from('users');
        $this->db->group_by('role');

        $query = $this->db->get();

        // Initialize counts to 0
        $counts = [
            'admin' => 0,
            'super_stockist' => 0,
            'distributor' => 0,
            'retailer' => 0
        ];

        // Process the query result
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if (isset($counts[$row->role])) {
                    $counts[$row->role] = $row->count;
                }
            }
        }

        return $counts;
    }
}
