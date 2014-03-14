<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'PHPMailer-master/PHPMailerAutoload.php';

class Forgot_lib {
	private $CI;

	public function __construct() {
		$this->CI = & get_instance();
		$this->CI->load->model('account_model');
    }
    
/* <<<< ========================================= HELPER FUNCTIONS ========================================= */
    private function is_password_change($username_or_email,$new_pwd) {    	
    	return $this->CI->account_model->update_password($username_or_email,password_hash($new_pwd,PASSWORD_DEFAULT));
    }
/* ========================================= HELPER FUNCTIONS ========================================= >>>> */

	public function forgot_pwd_request($username_or_email,$secret_question,$secret_answer) {
		$ret = 0;
		$temp = $this->CI->account_model->forgot_password_auth($username_or_email);
		
		if(!empty($temp)) {
			if($temp->usertype == 4) {
				$ret = 2;
			}
			else if($temp->usertype == 6) {
				$ret = 3;
			}
			//else if(($temp->username == $username_or_email || ($temp->email == $username_or_email && $temp->validemail == 1)) && ($temp->usertype != 4 || $temp->usertype != 6) && $temp->secretquestion == $secret_question && $temp->secretanswer == $secret_answer) {
			else if(($temp->username == $username_or_email || ($temp->email == $username_or_email && $temp->validemail == 1)) && $temp->secretquestion == $secret_question && $temp->secretanswer == $secret_answer) {
				$ret = 1;
			}
		}

		return $ret;
	}

    public function reset_password($username_or_email) {
    	$ret = FALSE;
    	$new_pwd = create_pass_code(8);

    	if($this->is_password_change($username_or_email,$new_pwd)) {
    		$ret = $new_pwd;
    	}

		return $ret;
    }

    public function change_password($username_or_email,$new_pwd) {
    	return $this->CI->account_model->update_password($username_or_email,password_hash($new_pwd,PASSWORD_DEFAULT));
    }

    /*
     * @return 0 = incorrect email or username
     * @return -1 = storing confirmation code to db failed
	 * @return 1 = confirmation code sent
	 * @return 2 = sending confirmation code failed, no internet access
	 * @return 3 = invalid email address	 
    */
    public function send_confirmation_code($email_or_username) {
    	$ret = 0;
		$res = $this->CI->account_model->get_code_and_email($email_or_username);

    	if(!empty($res)) {
			if($res->validemail && !empty($res->email)) {
		    	$code = create_pass_code(6);
		    	
				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->IsHTML(TRUE);
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;
				$mail->SMTPSecure = 'tls';
				$mail->SMTPAuth = TRUE;
				$mail->Username = 'noreply.ccsweb@gmail.com';
				$mail->Password = 'petterthecoolkid';
				$mail->setFrom('no-reply@ccsweb.com', 'CCS Web');
				$mail->addAddress($res->email);
				$mail->Subject = 'Confirmation Code!';
				$mail->Body = 'Your CCS Web confirmation code is: <strong>'.$code.'</strong>';
				
				if ($mail->send()) {
					$ret = ($this->CI->account_model->set_confirmation_code($email_or_username,$code)) ? 1 : -1;
				}
				else {
				    $ret = 2;
				}
			}
			else {
				$ret = 3;
			}
		}

		return $ret;
    }

    public function verify_confirmation_code($email_or_username,$confirmation_code) {
    	$ret = FALSE;
    	$res = $this->CI->account_model->get_confirmation_code($email_or_username);
    	
    	if(!empty($res->confirmationcode) && $res->confirmationcode == $confirmation_code) {
    		$ret = TRUE;
    	}

    	return $ret;
    }


    /*
     * @return 0 = sending validation code failed
     * @return -1 = storing validation code to db failed
	 * @return 1 = validation code sent
   */
    public function send_validation_code($email) {
    	$ret = 0;
    	$code = create_pass_code(6);

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->IsHTML(TRUE);
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = TRUE;
		$mail->Username = 'noreply.ccsweb@gmail.com';
		$mail->Password = 'petterthecoolkid';
		$mail->setFrom('no-reply@ccsweb.com', 'CCS Web');
		$mail->addAddress($email);
		$mail->Subject = 'Validation Code!';
		$mail->Body = 'Your email validation code is: <strong>'.$code.'</strong>';

		if ($mail->send()) {
			$ret = ($this->CI->account_model->set_validation_code($email,$code)) ? 1 : -1;
		}

		return $ret;
    }

    public function verify_validation_code($email,$validation_code) {
    	$ret = FALSE;
    	$res = $this->CI->account_model->get_validation_code($email);
    	
    	if(!empty($res->confirmationcode) && $res->confirmationcode == $validation_code) {
    		$this->CI->account_model->delete_validation_code($email);
    		$this->CI->account_model->set_valid_email($email);
    		$ret = TRUE;    	
    	}

    	return $ret;
    }

}