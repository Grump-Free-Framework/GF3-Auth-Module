<?php
namespace modules\auth\models;
class Registration extends \Model {

	public function registerUser($post_values) {

		if(($validity = $this->validateRegistration($post_values)) !== true) {
			return $validity;
		}

		unset($post_values['verify_password']);
		$post_values['password'] = password_hash($post_values['password'], PASSWORD_DEFAULT);

		try {
			$this->db->insert('auth', $post_values);
		} catch(PDOException $e) {
			return $e->getMessage();
		}

		return true;

	}

	public function validateRegistration($post_values) {

		$fields = $this->f3->get('active_module')->settings->register_fields;

		foreach($fields as $field => $info) {
			if(empty($post_values[$field])) {
				return "{$field} cannot be blank.";
			}
		}

		if($post_values['password'] != $post_values['verify_password']) {
			return "Passwords do not match.";
		}

		$check = $this->db->row("
			SELECT username, email FROM
				auth
			WHERE
				username=?
				OR email=?
		", [$post_values['username'], $post_values['email']]);

		if(!empty($check)) {
			if($check['username'] == $post_values['username']) {
				return "Username already registered.";
			} else if($check['email'] == $post_values['email']) {
				return "Email already registered.";
			}
		}

		return true;

	}

}
