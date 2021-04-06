<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller {

	public function indexAction() {
		$result = $this->model->getReviews();
		$vars = [
			'reviews' => $result,
		];
		$this->view->render('Главная страница', $vars);
	}
}