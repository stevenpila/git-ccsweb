<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
        //$this->authentication->do_logged_out();
    }
    
    public function index(){
        if(!$this->authentication->is_logged_in()) $this->authentication->redirect_account();
    }
}
?>
