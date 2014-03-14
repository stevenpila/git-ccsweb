<?php if( !defined('BASEPATH')) exit('No direct script access allowed');

class Privileges_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    public function add_user_privileges($user_type_id, $module_detail_id){
        $data = array(
            'user_type_id' => $user_type_id,
            'module_detail_id' =>$module_detail_id
        );
        
        $this->db->insert('ccs_user_type_details',$data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }

    public function delete_user_privileges($user_type_detail_id){
        $this->db->query("DELETE FROM ccs_user_type_details WHERE id = ?", array($user_type_detail_id));
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }

    public function get_services_by_name($module_name){
    	$query = $this->db->query("SELECT * FROM ccs_modules WHERE name = ? LIMIT 1", array($module_name));
        
        return ($query->num_rows())?$query->row()->id:FALSE;
    }

    public function get_services_function_by_name($method_name){
    	$query = $this->db->query("SELECT * FROM ccs_methods WHERE function = ? LIMIT 1", array($method_name));
        
        return ($query->num_rows())?$query->row()->id:FALSE;
    }

    public function get_service_and_service_function_by_id($module_id,$method_id){
        $query = $this->db->query("SELECT * FROM ccs_module_details WHERE module_id = ? AND method_id = ? LIMIT 1", array($module_id,$method_id));
        
        return ($query->num_rows())?$query->row()->id:FALSE;
    }

    public function get_all_privileges(){
    	$query = $this->db->query("SELECT cmd.*, cmo.name as module_name, cme.name as method_name 
    		FROM ccs_module_details cmd 
    		INNER JOIN ccs_modules cmo ON cmo.id = cmd.module_id 
    		INNER JOIN ccs_methods cme ON cme.id = cmd.method_id");

    	return ($query->num_rows())?$query->result():FALSE;
    }

    public function get_all_user_privileges(){
        $query = $this->db->query("SELECT cutd.id as id, cut.name as user_type, cmo.name as module_name, cme.name as method_name 
            FROM ccs_user_type_details cutd
            INNER JOIN ccs_user_types cut ON cut.id = cutd.user_type_id
            INNER JOIN ccs_module_details cmd ON cmd.id = cutd.module_detail_id 
            INNER JOIN ccs_modules cmo ON cmo.id = cmd.module_id 
            INNER JOIN ccs_methods cme ON cme.id = cmd.method_id");
        
        return ($query->num_rows())?$query->result():FALSE;
    }

    public function is_user_privileges_exists_by_id($module_detail_id){
        $query = $this->db->query("SELECT * FROM ccs_user_type_details WHERE module_detail_id = ? LIMIT 1", array($module_detail_id));
        
        return ($query->num_rows())?TRUE:FALSE;
    }

    public function is_user_privileges_exists($user_type_id,$module_detail_id){
        $query = $this->db->query("SELECT * FROM ccs_user_type_details WHERE user_type_id = ? AND module_detail_id = ?",array($user_type_id,$module_detail_id));
        
        return ($query->num_rows())?TRUE:FALSE;
    }
}