<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * City Model
 *
 * This model manages the retrieval of city data from the database.
 *
 * @package     CodeIgniter
 * @subpackage  Models
 * @category    Model
 * @author      Jules
 */
class City_model extends CI_Model {

    /**
     * Get Cities by State ID
     *
     * Retrieves all cities for a given state from the `cities` table.
     *
     * @param   int     $state_id   The ID of the state.
     * @return  array   An array of city objects.
     */
    public function get_cities_by_state($state_id)
    {
        $this->db->where('state_id', $state_id);
        $query = $this->db->get('cities');
        return $query->result();
    }
}
