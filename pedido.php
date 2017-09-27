<?
	// DEFINIR
	$peID = isset($_GET['peID']) ? $_GET['peID'] : 0;

  // PASAR A LIBRERIA


    // GET PEDIDO totales
	$debug=0;
    $sql='SELECT sum(peItCant) peItCantTot, sum(peItCant*peItPrecio) peItPrecioxCantTot, sum(peItCant*proEspacio) proEspacioTot

      FROM  Pedidos P, PedidosIntems PI, Productos Pro

      WHERE P.peID=PI.peID AND PI.proID=Pro.ProID';
    if($peID) $sql.= ' AND P.peID="'.$peID.' " '; 
     $sql.= ' GROUP BY P.peID  '; 
    $rsPT = $conn->execute($sql);
    if($debug) // DEBUG
      	echo $conn->errHTML() . $rsPuEn->display(); 


    // GET PEDIDO
    $sql='SELECT * , proDescrip, peItCant, peItPrecio, proEspacio, 
    	peItCant*peItPrecio peItPrecioxCant

      FROM  Pedidos P, PedidosIntems PI, Productos Pro

      WHERE P.peID=PI.peID AND PI.proID=Pro.ProID';
    if($peID) $sql.= ' AND P.peID="'.$peID.' " '; 
    $rsP = $conn->execute($sql);
    if($debug) // DEBUG
      	echo $conn->errHTML() . $rsPuEn->display(); 


    // GET EMBALAJE
    $sql='SELECT P.* 
      FROM  Productos P
      WHERE P.pcID=0 '; 
    $rsE= $conn->execute($sql);
    if($debug) // DEBUG
      	echo $conn->errHTML() . $rsPuEn->display(); 


    // GET EMBALAJE
    $sql='SELECT P.* 
      FROM  PuntoEntrega P
      WHERE P.pcID=0 '; 
    $rsPuEn= $conn->execute($sql);
    if($debug) // DEBUG
      	echo $conn->errHTML() . $rsPuEn->display(); 



      	// REGIJA PEDIDO
if($rsP) {
	?>


	<!-- CONTENEDOR PRINCIPAL -->

	<div class="container" style="padding-top: 1em;">

	<div class="row"> <!-- Cabecera -->

		<div class="col-xs-6">
				<div class="caption">
					Producto
				</div>
		</div>

		<div class="col-xs-2" style="text-align: center;">
				<div class="caption">
					cant
				</div>
		</div>

		<div class="col-xs-2" style="text-align: center;">
				<div class="caption">
				Precio
				</div>
		</div>

		<div class="col-xs-2" style="text-align: center;">
				<div class="caption">
					Total
				</div>
		</div>				


	</div>

	<? 
	for( ;!$rsP->eof;$rsP->moveNext()){
	?>

	

	<div class="row"> <!-- FILA NUEVA -->
		<div class="col-xs-6">
				<div class="caption">
					<?= $rsP->field('proDescrip')?>
				</div>
		</div>

		<div class="col-xs-2 style="text-align: center;">
			<div class="caption">
				<?= $rsP->field('peItCant')?>
			</div>
		</div>

		<div class="col-xs-1" style="text-align: right;"><div class="caption">$</div></div>
		<div class="col-xs-1" style="text-align: right;">
			<div class="caption">
				<?= $rsP->field('peItPrecio')?>
			</div>
		</div>

		<div class="col-xs-1" style="text-align: right;"><div class="caption">$</div></div>
		<div class="col-xs-1" style="text-align: right;">
			<div class="caption">
				<?= $rsP->field('peItPrecioxCant')?>
			</div>
		</div>				

					

	</div>
<? 
}

if ($rsE) {

	$cajasCantNN =  $rsE->field('proEspacio') % $rsPT->field('proEspacioTot')    ;
	$cajasPrecioTot = $rsE->field('proPrecio')*$cajasCantNN ;
?>

	<div class="row"> <!-- CAJAS proEstado	proDescrip	proDetalle	proFoto	proPrecio	proCosto	proEspacio --> 
		<div class="col-xs-6">
			<div class="caption">
					<?= $rsE->field('proDescrip')?>
			</div>
		</div>

		<div class="col-xs-2">
			<div class="caption">
					<?= $cajasCantNN?>
			</div>
		</div>

		<div class="col-xs-1" style="text-align: right;"><div class="caption">$</div></div>
		<div class="col-xs-1" style="text-align: right;">
			<div class="caption">
					<?= $rsE->field('proPrecio')?>
			</div>
		</div>

		<div class="col-xs-1" style="text-align: right;"><div class="caption">$</div></div>
		<div class="col-xs-1" style="text-align: right;">
			<div class="caption">
				<?= $cajasPrecioTot?> 
			</div>
		</div>				

				

	</div>
	<?

	}

	if($rsPT){
		$totalTot =  $rsPT->field('peItPrecioxCantTot') + $cajasPrecioTot;
	?>
	<div class="row"> <!-- TOTALES  peItCantTot, sum(peItCant*peItPrecio) peItPrecioxCantTot, sum(peItCant*proEspacio) proEspacioTot -->
		<div class="col-xs-9" >
			<div class="caption" style="text-align: right;" >
					Total : 
			</div>
		</div>
		<div class="col-xs-2" >
			<div class="caption" >
					
			</div>
		</div>

		<div class="col-xs-1">

				<div class="caption" style="text-align: right;">
					<?= $totalTot?>
				</div>
			</div>  
		</div>				


	</div>
	<? } 
	?>

</div> 
<?
}

include('entrega.php');