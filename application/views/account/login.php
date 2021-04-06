<div class="container">
	<div class="text-center">
		<form class="form-signin card my-5" method="POST">
			<h1 class="h3 mb-3 font-weight-normal">Вход</h1>
			<div class="input-block">
				<input type="email" name="email" class="form-control" placeholder="Email" required="" autofocus="" 
					<? if (isset($_SESSION['validation'])):?> 
						value="<?php echo $_SESSION['validation']['email'] ?>" 
					<? endif ?>>
				<input type="password" name="password" class="form-control" placeholder="Пароль" required="" 
					<? if (isset($_SESSION['validation'])):?> 
						value="<?php echo $_SESSION['validation']['password'] ?>" 
					<? endif ?>>
			</div>
			<button class="btn btn-lg btn-primary btn-block my-3" type="submit">Войти</button>
		</form>

		<?php if (isset($_SESSION['errors'])): ?>
		<p><?php echo $_SESSION['errors'] ?></p>
		<?php unset($_SESSION['errors']) ?>
		<? endif; ?>
	</div>
</div>
