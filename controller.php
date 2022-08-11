<?php
namespace modules\auth;
class controller extends \Controller {

    protected $successfulLoginPath = "/empty_module";

	public function get() {
        $this->f3->reroute("/{$this->f3->module}/login");
	}

    public function login() {

        $this->RedirectIfLoggedIn();

        $this->RenderView('login');

    }

    public function register() {

        $this->RedirectIfLoggedIn();

        $this->RenderView('register');

    }

    public function register_post() {



    }

    public function HandleBeforeRoute() {
        //requires PHP sessions to start, so always start session if it hasn't already been started.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function RedirectIfLoggedIn() {
        if(!empty($_SESSION['user'])) {

            $path = $this->settings->successfulLoginPath;
            if($path == 'default') {
                $path = $this->f3->get('defaultModule');
            }

            $this->f3->reroute($path);
        }
    }

}
