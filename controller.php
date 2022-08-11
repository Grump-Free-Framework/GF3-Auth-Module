<?php
namespace modules\auth;
class controller extends \Controller {

	public function get() {
        $this->f3->reroute("/{$this->f3->module}/login");
	}

    public function login() {

        $this->redirectIfLoggedIn();

		$this->f3->set('fields', $this->settings->login_fields);

        $this->RenderView('login');

    }

    public function register() {

        $this->redirectIfLoggedIn();

		$this->f3->set('fields', $this->settings->register_fields);

        $this->RenderView('register');

    }

    public function registerPost() {

        $Registration = $this->loadModel('Registration');

        $Registration->validateRegistration($_POST);

    }

    private function redirectIfLoggedIn() {
        if(!empty($_SESSION['user'])) {

            $path = $this->settings->successful_login_path;
            if($path == 'default') {
                $path = $this->f3->get('defaultModule');
            }

            $this->f3->reroute($path);
        }
    }

}
