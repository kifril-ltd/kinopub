<div class="container">
	<div class="card flex-row my-3">
		<img class="card-header w-25" src="/<? echo $review['movie_poster'] ?>" alt="Card image cap" />
		<div class="card-body d-flex flex-column w-75">
			<h1 class="card-title">
				<? echo $review['movie_name'] ?>
			</h1>
			<h5>Автор обзора:
				<? echo $author ?>
			</h5>
		</div>
	</div>
	<div class="movie-trailer d-flex justify-content-center">
		<iframe width="75%" height="500" src="<? echo $review['movie_trailer'] ?>" frameborder="0" allowfullscreen>
		</iframe>
	</div>
	<div class="review-text text-wrap text-break mx-5 my-5">
		<? echo $review['movie_review'] ?>
	</div>

	<div class="comments">
		<?php foreach($comments as $comment): ?>
		<div class="card bg-light my-2 mx-3">
			<div class="card-header">
				<h5 class="card-title">
					<? echo $comment['author_name'] ?>
				</h5>
				<h6 class="card-subtitle mb-2 text-muted">
					<? echo $comment['comment_datetime'] ?>
				</h6>
			</div>
			<div class="card-body">
				<p class="card-text">
					<? echo $comment['comment_text'] ?>
				</p>
			</div>
		</div>
		<?php endforeach; ?>
		<?php if (isset($_SESSION['auth'])): ?>
		<form action="/comment/add" method="POST">
			<div class="form-group mx-3">
				<label for="commentTextArea">Комментарий</label>
				<textarea rows="3" class="form-control" id="commentTextArea" name="commentText"></textarea>
			</div>
			<button type="submit" class="btn btn-success my-3 mx-3">Добавить комментарий</button>
		</form>
		<?php if (isset($_SESSION['errors'])): ?>
		<ul>
			<?php foreach ($_SESSION['errors'] as $val): ?>
			<?php if (!empty($val)) : ?>
			<li><?php echo $val ?></li>
			<? endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php unset($_SESSION['errors']) ?>
		<? endif; ?>
		<? endif; ?>
	</div>
</div>