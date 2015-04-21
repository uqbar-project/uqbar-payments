<?php require_once 'includes/util.php';?>
<?php require 'includes/encabezado.php'?>
  
    <div class="jumbotron">
      <div class="container">
        <h1>Colaborá con Uqbar</h1>
        <p>Uqbar es una fundación sin fines de lucro, que tiene como objetivos impulsar el desarrollo de la tecnología, expandir su utilización
        y ayudar en su difusión.</p> 
        <p>
        	Dentro de Uqbar se realizan muchas actividades y proyectos de desarrollo, pero para poder realizar esto necesitamos
        	de tu colaboración </p>
        <p><a class="btn btn-primary" href="http://uqbar.org" role="button">Ver más</a></p>
      </div>
    </div>

	<div class="container">
		<div class="row">
			<h2>Colaboraciones Mensuales</h2>
			<p>Tenemos distintas opciones de colaboraciones mensuales con las que
				nos podes ayudar. Todas expresadas en pesos argentinos, por ahora
				solo recibimos donaciones dentro de Argentina.</p>
			<p>Para que puedas realizar la donación debes estar logeado.</p>
			<p>
			<?= renderBotonesDonaciones() ?>
		</div>
	</div>
        
<?php require 'includes/pie.php';?>