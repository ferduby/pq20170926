<? 
	// INCLUDES
include('includes/DB_Conectar.php');


?>
<!DOCTYPE html>
<html>
<? include('includes/head.php'); ?>
<body>
	<header>
		<!-- 
		<img src="img/top.jpg"/>
		<h1>Pan y Queso</h1> 
		<h2>Bienvenidos</h2> -->
	</header>
	<? 

	include('includes/nav.php'); 

	if($pcID){
		include('listaProductos.php');
	}
	else
		include('pedido.php');



	include('includes/footer.php'); 

	?>
</body>
</html>