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
        $this->load->library('form_validation');
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
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

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
     * Edit Admin
     *
     * Handles the form submission for updating an admin.
     *
     * @param   int $id The ID of the admin to edit.
     */
    public function edit($id)
    {
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|trim');

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
        $admin = $this->User_model->get_user_by_id($id);
        echo json_encode($admin);
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
}
