<?php
	$this->title = $author->FirstName . ' ' . $author->LastName;
?>
<div class="alert alert-primary text-center" role="alert">
  Не установлено приложение? <a href="/">Установить</a>
</div>
<div class="container text-center">
	<button class="btn btn-primary" onclick="openUrl()">Открыть в приложении &nbsp;🐾🐾</button>
</div>

<script type="text/javascript">	 
	function openUrl() {
		window.location = 'meow://books/author/<?=$id?>'; 
	}      
</script>