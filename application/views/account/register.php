<div class="text-center">
	<form class="form-signup" action="/account/register" method="post">
		<h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
		<div class="input-block">
			<input type="text" name="login" class="form-control" placeholder="Login" required="" autofocus="" 
			<? if (isset($_SESSION['validation'])):?> 
				value="<?=$_SESSION['validation']['login']?>"
			<? endif ?>>
			<input type="email" name="email" class="form-control" placeholder="Email" required="" autofocus="" 
			<? if(isset($_SESSION['validation'])):?> 
				value="<?php echo $_SESSION['validation']['email'] ?>"
			<? endif ?>>
			<input type="password" name="password" class="form-control" placeholder="Пароль" required="" 
			<? if (isset($_SESSION['validation'])):?> 
				value="<?php echo $_SESSION['validation']['password'] ?>"
			<? endif ?>>
			<input type="password" name="passwordConf" class="form-control" placeholder="Подтверждение пароля" required="" 
			<? if (isset($_SESSION['validation'])):?>
				value="<?php echo $_SESSION['validation']['passwordConf'] ?>"
			<? endif ?>>
		</div>

		<div class="checkbox mb-3">
			<label class="pt-2">
				<input type="checkbox" name="accept" value="accept-pp"> Согласие на обработку персональных данных
			</label>
		</div>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
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
</div>