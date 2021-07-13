<div>
	<h4>Настройка базы данных</h4>
	<div>
		<form method="post">
			<div>
				<label>Сервер Mysql</label>
				<input type="text" name="dbHost" placeholder="localhost">
			</div>

			<div>
				<label>Название базы данных</label>
				<input type="text" name="dbName" placeholder="" required="">
			</div>

			<div>
				<label>Имя пользователя</label>
				<input type="text" name="dbUser" placeholder="" required="">
			</div>

			<div>
				<label>Пароль</label>
				<input type="text" name="dbPassword" placeholder="" required="">
			</div>

			<div>
				<label>Кодировка </label>
				<input type="text" name="dbCharset" placeholder="utf8mb4">
			</div>
			<div>
				<button type="submit">Установить</button>
			</div>
		</form>
	</div>
</div>

<style type="text/css">
	label {
		display: block;
	}
</style>