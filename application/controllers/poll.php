<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poll extends MY_Controller{
	public function __construct() {
        parent::__construct();

        $this->load->model('poll_model','poll');

        $date = new Datetime();
        $this->poll->close_poll_by_expiration_date($date->format('Y-m-d H:i:s'));
    }

    public function index(){
    	$this->data['polls'] = $this->poll->get_all_polls();
        $this->data['datetime'] = $this->datetime->format('F d, Y H:i:s');
    }

    public function create_poll(){
    	if($data = $this->input->post(NULL,TRUE)){
    		extract($data);
    		$user_id = $this->authentication->user_id();

            if(isset($time) && isset($date)){
                if(strstr($time, 'PM')){
                    $time = explode(':', $time);
                    $time = ($time[0] + 12) . ':' . $time[1];
                }

                $time = substr($time, 0, 5);
                $expire = $date . ' ' . $time . ':00';
            }
            else $expire = FALSE;
            
    		if($poll = $this->poll->add_new_poll($user_id, $topic, $this->datetime->format('Y-m-d H:i:s'), $expire)){
    			foreach($option as $opt){
    				$this->poll->add_poll_options_by_id($poll, $opt);
    			}
    		}
    	}

    	redirect('poll');
    }

    /*****************************

            AJAX FUNCTIONS

    *****************************/
    public function verify_topic(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if($this->poll->get_poll_by_name($topic)){
                $status = 1;
            }
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function delete_poll(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if($this->poll->delete_poll_by_id($poll_id)){
                if($this->poll->delete_poll_options_by_id($poll_id)){
                    $this->poll->delete_poll_option_voters_by_id($poll_id);
                }

                $status = 1;
            }
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function is_poll_closed(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if($this->poll->get_poll_status_by_id($poll_id) == 'Closed') $status = 1;
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function is_user_voted(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);
            $user_id = $this->authentication->user_id();

            if($this->poll->is_user_voted_poll_by_id($user_id,$poll_id)) $status = 1;
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function vote_poll_option(){
        $status = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);
            $user_id = $this->authentication->user_id();

            if($this->poll->add_new_poll_voter_by_id($user_id,$poll_id,$option_id)){
                if($this->poll->update_poll_option_vote_by_id($option_id)) $status = 1;
            }
        }

        echo json_encode(array('status' => $status));

        $this->view = false;
    }

    public function open_close_poll(){
        $response = 0;

        if($data = $this->input->post(NULL,TRUE)){
            extract($data);

            if($this->poll->update_close_open_poll_by_id($poll_id,$status)) $response = 1;
        }

        echo json_encode(array('status' => $response));

        $this->view = false;
    }
}
?>