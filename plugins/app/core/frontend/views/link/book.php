<?php
	$this->title = $book->author->FirstName . ' ' . $book->author->LastName . ' - ' . $book->Title;
?>
<div class="alert alert-primary text-center" role="alert">
  Не установлено приложение? <a href="/">Установить</a>
</div>
<div class="container text-center">
	<button class="btn btn-primary" onclick="openUrl()">Открыть книгу в приложении &nbsp;🐾🐾</button>
</div>

<script type="text/javascript">	 
	function openUrl() {
		window.location = 'meow://books/<?=$id?>'; 
	}      
</script>