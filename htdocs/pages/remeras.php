<?php 
	$_SESSION['login_backUrl'] = 'remeras.php';
?>

	<div class="jumbotron">
      <div class="container">
        <h1>Remeras Uqbar - WISIT 2015</h1>
        <p>Vamos a hacer remeras de UQBAR, para usar en el WISIT 15 y que todos nos se den cuenta de nuestra grossitud (?)</p> 
        <p>Si no te interesa la remera, también podes ayudarnos con tu donación mensual, entrando <a href='/'>aquí</a></p> 
      </div>
    </div>

	<div class="container">
		<div class="row">
		<div class="col-md-8">
			<h1>Si... Remeras!!!</h1>
			<div class="col-md-6 contenedorRemera">
				<p>Nuestro Diseño va a quedar así (o cuando Ariel me pase la imagen definitiva).</p>
				<img alt="Modelo de la Remera" src="imgs/modeloRemera.jpg"/>
				<p>
			</div>
			<div class="col-md-6 contenedorRemera">
					Vamos a hacer en distintos talles, por lo que tenes que elegir el que te corresponde:
				</p>
				<img alt="Detalles de talles" src="http://remerasxd.com/wp-content/uploads/2013/09/talles.jpg"/>
				<p>
					Además tenemos el XXL que es 58x76.
				</p>
			</div>
		</div>
	<?php 
		if(!isLogged()){
	?>
			<div class='col-md-4'>
				<h2>Compra Tu Remera</h2>
				<p>
					Para poder comprar tu remera tenes que estar logueado con tu cuenta de Google. 
				</p>
					<a class='btn btn-primary' href='login.php'
							 role='button'>Log in con Usuario de Google</a>
			</div>
	<?php 
		}else{
	?>
			<div class='col-md-4'>
				<h2>Compra Tu Remera</h2>
				<form action="doRemeras.php" method="post" >
					<div class="form-group">
						<label for="cant">Cantidad</label>
						<input type="text" name="cant" value="1"  class="form-control" />
					</div>
					<div class="form-group">
						<label for="talle">Talle</label>
						<select class="form-control" name="talle">
							<option value="S">S</option>
							<option value="M">M</option>
							<option value="L">L</option>
							<option value="XL">XL</option>
							<option value="XXL">XXL</option>
						</select>
					</div>
					
					Las remeras tienen 3 valores posibles, para nosotros es importante que nos puedas ayudar
					a juntar plata, esta plata es para poder comprar remeras extras para regalar y para poder
					financiar varias de las actividades que hace UQBAR todo el año.
					<br/>
					<br/>
					
					<div class="form-group">
						<label for="valor">Valor:</label>

						<div class="radio">
						  <label>
						    <input type="radio" name="valor" value="160" checked> $ 160
						  </label>
						</div>
						<div class="radio">
						  <label>
						    <input type="radio" name="valor" value="120"> $ 120
						  </label>
						</div>
						<div class="radio">
						  <label>
						    <input type="radio" name="valor" value="80"> $ 80
						  </label>
						</div>
					</div>
					<input type="submit" class="btn btn-primary" value="Comprar">
				</form>
			</div>
	<?php 
		}
	?>
		</div>
	</div>
