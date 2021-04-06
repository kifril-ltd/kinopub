<?php

namespace application\models;

use application\core\Model;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\NotBlank;

class Comment extends Model {

	public function validateComment($post) {
		$validator = Validation::createValidator();
        $this->errors = [];

		$this->errors[] = (string)$validator->validate($post['commentText'], [
			new NotBlank(['message' => 'Необходимо написать текст комментария']),	
		]);

		$this->errors = array_filter($this->errors);

		return empty($this->errors);
	}

	public function addComment($movieId, $authorId, $post) {
		$params = [
			'movieId' => $movieId,
			'authorId' => $authorId,
			'commentText' => $post['commentText'],
			'commentDateTime' => date("Y-m-d H:i:s"),
		];

		$this->db->query('insert into comment 
						 (comment_text, comment_datetime, comment_movie_id, comment_author_id) 
						 values (:commentText, :commentDateTime, :movieId, :authorId)', $params);
	}

}