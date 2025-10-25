<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * State Model
 *
 * This model manages the retrieval of state data from the database.
 *
 * @package     CodeIgniter
 * @subpackage  Models
 * @category    Model
 * @author      Jules
 */
class State_model extends CI_Model {

    /**
     * Get All States
     *
     * Retrieves all states from the `states` table.
     *
     * @return  array   An array of state objects.
     */
    public function get_states()
    {
        $query = $this->db->get('states');
        return $query->result();
    }
}
