<?php

namespace application\models;

use application\core\Model;

class Main extends Model {

	public function getReviews() {
		$result = $this->db->row('SELECT movie_id, 
										 movie_name, 
										 movie_poster, 
										 movie_review, 
										 review_datetime 
										 FROM movie 
										 ORDER BY review_datetime desc');
		return $result;
	}

}