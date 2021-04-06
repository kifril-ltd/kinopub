<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo $title; ?></title>
	
	<link rel="stylesheet" href="/public/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/public/bootstrap/css/bootstrap-utilities.css">
	<link rel="stylesheet" href="/public/bootstrap/css/bootstrap-grid.css">
	<link rel="stylesheet" href="/public/style.css">
	<script src="/public/scripts/jquery.js"></script>
	<!-- <script src="/public/scripts/form.js"></script> -->
</head>

<body>
	<header class="container">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
        <a class="navbar-brand me-md-auto ps-5" href="/">KinoPub</a>

		<?php if (isset($_SESSION['auth'])): ?>
			<?php if ($_SESSION['auth']['acc_is_moderator']): ?>
				<a class="btn btn-outline-success mx-2" href="/movie/add">Создать обзор</a>
			<?php endif; ?>

			<p class="text-light my-auto mx-2">Привет, <?php echo $_SESSION['auth']['acc_name'] ?></p>
			<a class="btn btn-outline-secondary mx-2" href="/account/logout">Выход</a>
		<?php else: ?>
        	<a class="btn btn-outline-secondary mx-2" href="/account/login">Вход</a>
        	<a class="btn btn-outline-primary mx-2" href="/account/register">Регистрация</a>
		<?php endif; ?>
      </nav>
	</header>

	<?php echo $content; ?>
</body>

</html>