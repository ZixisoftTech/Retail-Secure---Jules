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

    /**
     * Get Users by Role
     *
     * Retrieves all users with a specific role.
     *
     * @param   string  $role The role to filter by.
     * @return  array   An array of user objects.
     */
    public function get_users_by_role($role)
    {
        $query = $this->db->get_where('users', ['role' => $role]);
        return $query->result();
    }

    /**
     * Get User by ID
     *
     * Retrieves a single user by their ID.
     *
     * @param   int     $id The user ID.
     * @return  object  The user object.
     */
    public function get_user_by_id($id)
    {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row();
    }

    /**
     * Add User
     *
     * Inserts a new user into the database.
     *
     * @param   array   $data The user data.
     * @return  int     The ID of the newly inserted user.
     */
    public function add_user($data)
    {
        // Hash the password before inserting
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    /**
     * Update User
     *
     * Updates an existing user's data.
     *
     * @param   int     $id   The ID of the user to update.
     * @param   array   $data The data to update.
     * @return  bool    TRUE on success, FALSE on failure.
     */
    public function update_user($id, $data)
    {
        // If password is being updated, hash it
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            // Avoid updating the password if it's empty
            unset($data['password']);
        }
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    /**
     * Delete User
     *
     * Deletes a user from the database.
     *
     * @param   int     $id The ID of the user to delete.
     * @return  bool    TRUE on success, FALSE on failure.
     */
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    /**
     * Update Wallet Balance
     *
     * Updates a user's wallet balance and logs the transaction.
     *
     * @param   int     $user_id            The ID of the user.
     * @param   float   $amount             The amount to credit or debit.
     * @param   string  $transaction_type   'credit' or 'debit'.
     * @return  bool    TRUE on success, FALSE on failure (e.g., insufficient funds).
     */
    public function update_wallet_balance($user_id, $amount, $transaction_type)
    {
        $this->db->trans_start();

        // Get current balance
        $user = $this->get_user_by_id($user_id);
        $current_balance = $user->wallet_balance;

        if ($transaction_type === 'debit') {
            if ($current_balance < $amount) {
                $this->db->trans_rollback();
                return FALSE; // Insufficient balance
            }
            $new_balance = $current_balance - $amount;
        } else {
            $new_balance = $current_balance + $amount;
        }

        // Update user's wallet balance
        $this->db->where('id', $user_id);
        $this->db->update('users', ['wallet_balance' => $new_balance]);

        // Log the transaction
        $transaction_data = [
            'user_id' => $user_id,
            'amount' => $amount,
            'transaction_type' => $transaction_type,
            'remark' => ucfirst($transaction_type) . ' by Super Admin',
            // Set other fields to default or placeholder values as they are not provided in the form
            'product_type' => 'N/A',
            'payment_status' => 'paid',
            'rate' => 0.00
        ];
        $this->db->insert('wallet_transactions', $transaction_data);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Get Wallet Transactions
     *
     * Retrieves all wallet transactions for a given user.
     *
     * @param   int     $user_id    The ID of the user.
     * @return  array   An array of transaction objects.
     */
    public function get_wallet_transactions($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('wallet_transactions');
        return $query->result();
    }
}
