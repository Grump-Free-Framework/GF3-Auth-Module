<?php
namespace modules\auth\models;
class Registration extends \Model {

	public function validateRegistration($post_values) {

		foreach($this->f3->get('active_module')->settings->required_fields as $field) {
			if(empty($post_values[$field])) {
				die("{$field} cannot be blank.");
			}
		}

	}

}
