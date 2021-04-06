<?php

namespace application\models;

use application\core\Model;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class Movie extends Model {

	public function getReviewById($id) {
		$param = [
			'id' => $id,
		];
		$result = $this->db->row('SELECT * FROM movie where movie_id=:id', $param);
		return $result[0];
	}

	public function getUserNameById($id) {
		$param = [
			'id' => $id,
		];
		$result = $this->db->column('SELECT acc_name FROM account where acc_id=:id', $param);
		return $result;
	}

	public function validateAddForm($post, $file) {
		$validator = Validation::createValidator();
        $this->errors = [];

		$this->errors[] = (string)$validator->validate($post['movieName'], [
			new NotBlank(['message' => 'Необходимо указать название фильма']),	
		]);

		if (empty($file['tmp_name'])) {
			$this->errors[] = 'Загрузка постера является обязательной';
		}

		$this->errors[] = (string)$validator->validate($file['tmp_name'], [
			new Assert\File([
				'disallowEmptyMessage' => 'Загруженный файл является пустым',
				'maxSize' => '5M',
				'maxSizeMessage' => 'Максимальный размер файла 5Мб',
				'mimeTypes' => ['image/png', 'image/jpeg'],
				'mimeTypesMessage' => 'Загрузите изображение в формате png или jpeg',
			]),
		]);
		
		$this->errors[] = (string)$validator->validate($post['movieTrailer'], [
			new NotBlank(['message' => 'Необходимо указать ссылку на трейлер фильма']),	
			new Regex([
				'pattern' => '/^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/',
				'message' => 'Ссылка не является корректной ссылкой на youtube',
			]),
		]);

		$this->errors[] = (string)$validator->validate($post['reviewText'], [
			new NotBlank(['message' => 'Необходимо написать текст обзора']),
		]);

		$this->errors = array_filter($this->errors);

		return empty($this->errors);
	}

	public function addReview($authorId, $post, $file) {
		$params = [
			'authorId' => $authorId,
			'movieName' => $post['movieName'],
			'moviePoster' => 'posters/' . basename($file['tmp_name'] . '.png'),
			'movieTrailer' => $this->getEmbedYoutubeUrl($post['movieTrailer']),
			'reviewText' => $post['reviewText'],
			'reviewDateTime' => date("Y-m-d H:i:s"),
		];
		
		move_uploaded_file($file['tmp_name'], $params['moviePoster']);

		$this->db->query('insert into movie 
						 (movie_name, movie_poster, movie_trailer, movie_review, review_datetime, review_author_id) 
						 values (:movieName, :moviePoster, :movieTrailer, :reviewText, :reviewDateTime, :authorId)', $params);
		
	}

	public function getCommentsByMovieId($id) {
		$param = [
			'movieId' => $id,
		];
		$result = $this->db->row('SELECT * FROM comment where comment_movie_id=:movieId order by comment_datetime desc', $param);
		foreach ($result as &$comment) {
			$comment['author_name'] = $this->getUserNameById($comment['comment_author_id']);
		}
		return $result;
	}

	public function getEmbedYoutubeUrl($url) {
		$shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
		$longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';
	
		if (preg_match($longUrlRegex, $url, $matches)) {
			$youtube_id = $matches[count($matches) - 1];
		}
	
		if (preg_match($shortUrlRegex, $url, $matches)) {
			$youtube_id = $matches[count($matches) - 1];
		}

		return 'https://www.youtube.com/embed/' . $youtube_id;
	}

}