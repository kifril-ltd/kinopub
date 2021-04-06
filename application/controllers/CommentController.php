<?php

namespace application\controllers;

use application\core\Controller;

class CommentController extends Controller {

	public function addAction() {
		$movieId = basename($_SERVER['HTTP_REFERER']);
		if (!empty($_POST)) {
			if (!$this->model->validateComment($_POST)) {
				$_SESSION['errors'] = $this->model->errors;
				$this->view->redirect('/movie/review/' . $movieId);
			}
			else {
				$this->model->addComment($movieId, $_SESSION['auth']['acc_id'], $_POST);
				$this->view->redirect('/movie/review/' . $movieId);
			}
		}

		$this->view->redirect('/movie/review/' . $movieId);
	}
}