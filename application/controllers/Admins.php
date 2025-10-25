<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admins Controller
 *
 * This controller handles the management of users with the 'admin' role.
 *
 * @package     CodeIgniter
 * @subpackage  Controllers
 * @category    Controller
 * @author      Jules
 */
class Admins extends MY_Controller {

    /**
     * Constructor
     *
     * Loads the User_model and necessary libraries.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('State_model');
        $this->load->model('City_model');
        $this->load->library('form_validation');
    }

    /**
     * Get Cities by State (AJAX)
     *
     * Fetches cities for a given state ID and returns them as JSON.
     *
     * @param   int $state_id The ID of the state.
     */
    public function get_cities_by_state($state_id)
    {
        $cities = $this->City_model->get_cities_by_state($state_id);
        echo json_encode($cities);
    }

    /**
     * Index
     *
     * Displays the list of all admins.
     */
    public function index()
    {
        $data['title'] = 'Manage Admins';
        $data['admins'] = $this->User_model->get_users_by_role('admin');
        $data['states'] = $this->State_model->get_states();
        $this->load_view('admins/index', $data);
    }

    /**
     * Add Admin
     *
     * Handles the form submission for adding a new admin.
     */
    public function add()
    {
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim|exact_length[10]|numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('gst_number', 'GST Number', 'required|trim|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = $this->input->post();
            $data['role'] = 'admin';
            $this->User_model->add_user($data);
            $this->session->set_flashdata('success', 'Admin added successfully.');
        }
        redirect('admins');
    }

    /**
     * Email Check (Callback)
     *
     * Custom validation rule to check if the email is unique, ignoring the current user.
     *
     * @param   string  $email  The email address to check.
     * @param   int     $id     The ID of the user to exclude from the check.
     * @return  bool    TRUE if the email is valid, FALSE otherwise.
     */
    public function email_check($email, $id)
    {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'The {field} field must contain a unique value.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Edit Admin
     *
     * Handles the form submission for updating an admin.
     *
     * @param   int $id The ID of the admin to edit.
     */
    public function edit($id)
    {
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_email_check[' . $id . ']');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim|exact_length[10]|numeric');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('gst_number', 'GST Number', 'required|trim|regex_match[/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = $this->input->post();
            $this->User_model->update_user($id, $data);
            $this->session->set_flashdata('success', 'Admin updated successfully.');
        }
        redirect('admins');
    }

    /**
     * Get Admin Data (for AJAX)
     *
     * Fetches a single admin's data and returns it as JSON.
     *
     * @param   int $id The ID of the admin.
     */
    public function get_admin($id)
    {
        $admin = $this->User_model->get_user_with_parent_details($id);
        echo json_encode($admin);
    }

    /**
     * Get CSRF Token (AJAX)
     *
     * Provides a new CSRF token hash for AJAX requests.
     */
    public function get_csrf_token()
    {
        $token = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        echo json_encode($token);
    }

    /**
     * Delete Admin
     *
     * Deletes an admin.
     *
     * @param   int $id The ID of the admin to delete.
     */
    public function delete($id)
    {
        $this->User_model->delete_user($id);
        $this->session->set_flashdata('success', 'Admin deleted successfully.');
        redirect('admins');
    }

    /**
     * Toggle User Status (AJAX)
     *
     * Updates the status of a user (active/inactive).
     */
    public function toggle_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $new_status = ($status === 'active') ? 'inactive' : 'active';

        $this->User_model->update_user($id, ['status' => $new_status]);

        echo json_encode(['success' => true, 'new_status' => $new_status]);
    }

    /**
     * Manage Wallet (AJAX)
     *
     * Handles credit/debit transactions for a user's wallet.
     */
    public function manage_wallet()
    {
        $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
        $this->form_validation->set_rules('product_type', 'Product Type', 'required|trim');
        $this->form_validation->set_rules('transaction_type', 'Transaction Type', 'required|in_list[credit,debit]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('rate', 'Rate', 'required|numeric');
        $this->form_validation->set_rules('payment_status', 'Payment Status', 'required|in_list[paid,not_paid,scheme]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'error' => validation_errors()]);
            return;
        }

        $user_id = $this->input->post('user_id');
        $transaction_type = $this->input->post('transaction_type');
        $amount = $this->input->post('amount');

        $data = [
            'user_id' => $user_id,
            'product_type' => $this->input->post('product_type'),
            'transaction_type' => $transaction_type,
            'amount' => $amount,
            'payment_status' => $this->input->post('payment_status'),
            'rate' => $this->input->post('rate'),
            'remark' => $this->input->post('remark')
        ];

        $result = $this->User_model->update_wallet_balance($user_id, $amount, $transaction_type, $data);

        if ($result['success']) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $result['message']]);
        }
    }

    /**
     * Get Wallet Transactions (AJAX)
     *
     * Fetches the transaction history for a given user.
     *
     * @param int $user_id The ID of the user.
     */
    public function get_wallet_transactions($user_id)
    {
        $transactions = $this->User_model->get_wallet_transactions($user_id);
        echo json_encode($transactions);
    }
}
