<?php if( !defined('BASEPATH')) exit('No direct script access allowed');

class User_type_detail_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function add_user_type_detail($user_type_id, $module_detail_id){
        $data = array(
            'user_type_id' => $user_type_id,
            'module_detail_id' =>$module_detail_id
        );
        
        $this->db->insert('ccs_user_type_details',$data);
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    public function delete_user_type_detail($user_type_detail_id){
        $this->db->query("DELETE FROM ccs_user_type_details WHERE id = $user_type_detail_id");
        
        return ($this->db->affected_rows())?TRUE:FALSE;
    }
    
    public function get_all_user_type_and_module_detail(){
        $query = $this->db->query("SELECT cutd.id as id, cut.name as user_type, cmo.name as module_name, cme.name as method_name 
            FROM ccs_user_type_details cutd
            INNER JOIN ccs_user_types cut ON cut.id = cutd.user_type_id
            INNER JOIN ccs_module_details cmd ON cmd.id = cutd.module_detail_id 
            INNER JOIN ccs_modules cmo ON cmo.id = cmd.module_id 
            INNER JOIN ccs_methods cme ON cme.id = cmd.method_id");
        
        return ($query->num_rows())?$query->result():FALSE;
    }
    
    public function is_user_type_detail_exists_by_id($module_detail_id){
        $query = $this->db->query("SELECT * FROM ccs_user_type_details WHERE module_detail_id = ? LIMIT 1",array($module_detail_id));
        
        return ($query->num_rows())?TRUE:FALSE;
    }
    
    public function is_user_type_authorized_by_id($user_type_id,$module_detail_id){
        $query = $this->db->query("SELECT * FROM ccs_user_type_details WHERE user_type_id = ? AND module_detail_id = ?",array($user_type_id,$module_detail_id));
        
        return ($query->num_rows())?TRUE:FALSE;
    }
}
?>
