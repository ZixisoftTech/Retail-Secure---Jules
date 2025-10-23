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

}
