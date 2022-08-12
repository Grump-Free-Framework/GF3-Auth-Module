<?php
namespace modules\auth\models;
class Login extends \Model {

    protected $user_info = null;

    public function loginUser($post_values) {

        if(!is_array($validity = $this->validateLogin($post_values))) {
			return $validity;
		}

        $session_fields = $this->f3->get('active_module')->settings->database_columns_for_user_session;

        $user = [];
        foreach($validity as $db_key => $value) {
            if(in_array($db_key, $session_fields)) {
                $user[$db_key] = $value;
            }
        }

        $_SESSION['user'] = $user;
        return $user;

    }

    public function validateLogin($post_values) {

        $username = $post_values['username'] ?: $post_values['identifier'];
        $email = $post_values['email'] ?: $post_values['identifier'];

        $user = $this->db->row("SELECT * FROM auth WHERE username=? OR email=?", [$username, $email]);
        if(empty($user)) {
            return "Username or email is not registered.";
        }

        if(!password_verify($post_values['password'], $user['password'])) {
            return "The entered credentials do not match our records.";
        }

        return $user;

    }

}
