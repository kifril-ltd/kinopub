<?php

namespace application\controllers;

use application\core\Controller;

class MovieController extends Controller {

	public function reviewAction() {
		$result = $this->model->getReviewById($this->route['id']);
		$author = $this->model->getUserNameById($result['review_author_id']);
		$comments = $this->model->getCommentsByMovieId($this->route['id']);
		$vars = [
			'review' => $result,
			'author' => $author,
			'comments' => $comments,
		];
		$this->view->render($result['movie_name'], $vars);
	}

	public function addAction() {
		if (!empty($_POST)) {
			if (!$this->model->validateAddForm($_POST, $_FILES['moviePoster'])) {
				$_SESSION['errors'] = $this->model->errors;
				foreach ($_POST as $key => $value) {
					$_SESSION['validation'][$key] = $value;
				}
				$this->view->redirect('add');
			}
			else {
				$this->model->addReview($_SESSION['auth']['acc_id'], $_POST, $_FILES['moviePoster']);
				$this->view->redirect('review/' . $this->model->db->lastInsertId());
			}
		}
		$this->view->render('Создание обзора');
		unset($_SESSION['validation']);
	}

	public function commentAction() {

		$this->view->redirect('review/' . $this->route['id']);
	}
}