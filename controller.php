<?php
namespace modules\auth;
class controller extends \Controller {

	public function get() {
        $this->reroute("/login", SELF::REROUTE_MODULE);
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

	public function loginPost() {

		$this->redirectIfLoggedIn();

		$login = $this->loadModel('Login');

		if(is_array($response = $login->loginUser($_POST))) {
			$this->redirectIfLoggedIn();
		} else {
			$this->reroute("/login?error={$response}", SELF::REROUTE_MODULE);
		}

	}

    public function registerPost() {

        $registration = $this->loadModel('Registration');

		if(($response = $registration->registerUser($_POST)) === true) {
			$this->loginPost();
		} else {
			$this->reroute("/register?error={$response}", SELF::REROUTE_MODULE);
		}

    }

	public function logout() {
		unset($_SESSION['user']);
		$this->reroute('/login', SELF::REROUTE_MODULE);
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
