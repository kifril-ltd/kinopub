<?php

namespace application\controllers;

use application\core\Controller;

class AccountController extends Controller {

	public function loginAction() {
		if (!empty($_POST)) {
			if (!$this->model->validateLoginForm($_POST)) {
				$_SESSION['errors'] = $this->model->error;
				foreach ($_POST as $key => $value) {
					$_SESSION['validation'][$key] = $value;
				}
				$this->view->redirect('login');
			}
			elseif (!$this->model->login($_POST)) {
				$_SESSION['errors'] = $this->model->error;
				foreach ($_POST as $key => $value) {
					$_SESSION['validation'][$key] = $value;
				}
				$this->view->redirect('login');
			}
			else {
				$this->view->redirect('/');		
			}
		}	
		$this->view->render('Вход');
		unset($_SESSION['validation']);
	}

	public function registerAction() {
		if (!empty($_POST)){
			if (!$this->model->validateRegisterForm($_POST)) {
				$_SESSION['errors'] = $this->model->error;
				foreach ($_POST as $key => $value) {
					$_SESSION['validation'][$key] = $value;
				}
				$this->view->redirect('register');
			}
			else {
				$this->model->register($_POST);
				$this->model->login($_POST);
				$this->view->redirect('/');
			}
		}
		$this->view->render('Регистрация');
		unset($_SESSION['validation']);
	}

	public function logoutAction() {
		$this->model->logout();
		$this->view->redirect('login');
	}

}