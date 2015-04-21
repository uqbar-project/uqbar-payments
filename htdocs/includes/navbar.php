
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#navbar" aria-expanded="false"
				aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span> <span
					class="icon-bar"></span> <span class="icon-bar"></span> <span
					class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="http://uqbar.org">Uqbar</a>
		</div>
<?php 
	if(isLogged()){
?>		
		<div id="navbar" class="navbar-collapse collapse">
			<a class="btn navbar-btn btn-success navbar-right" href="login.php?salir=1"
				role="button">Salir</a>
	        <ul class="nav navbar-nav navbar-right">
	            <li><a>Hola <?= displayName()?></a></li>
	        </ul>			
		</div>
<?php 
	}else{
?>		
		<div id="navbar" class="navbar-collapse collapse">
			<a class="btn navbar-btn btn-success navbar-right" href="login.php"
				role="button">Ingresar con tu Usuario de Google</a>
		</div>
<?php 
	}
?>		
	</div>
</nav>
