<div class="container">
	<?php foreach($reviews as $review): ?>
	<div class="card flex-row my-3">
		<img class="card-header w-25" src="<? echo $review['movie_poster'] ?>" alt="Card image cap" />
		<div class="card-body d-flex flex-column justify-content-between w-75">
			<h2 class="card-title">
				<? echo $review['movie_name'] ?>
			</h2>
			<div class="card-text text-wrap">
				<? echo implode(' ', array_slice(explode(' ', $review['movie_review']), 0, 100)) . "..." ?>
			</div>
			<div class="c-footer">
				<a class="btn btn-primary" href="<? echo 'movie/review/' . $review['movie_id'] ?>">Подробнее...</a>
				<p class="card-text align-text-bottom"><small class="text-muted">
						<? echo $review['review_datetime'] ?></small></p>
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>