<? 
  // PASAR A LIBRERIA

    // relacion precion costo %
    $debug=0;
    $sql='SELECT proID, proDescrip, proPrecio, procosto, 
      ROUND(( proPrecio *100 / procosto ) -100 ) AS rel,
      proPrecio - procosto AS dif
      FROM  Productos 
      WHERE proEstado="A"'; 
    $rsP = $conn->execute($sql);
      if($debug) // DEBUG
      echo $sql."<br>".$rsP->display().'<br>'.$conn->errHTML(); 

    // promedio de ganancia precion costo %
    $sql='SELECT sum(proPrecio), avg(proPrecio), avg (proPrecio - procosto)
      FROM  Productos 
      WHERE proEstado="A"'; 
    $rsP = $conn->execute($sql);
      if($debug) // DEBUG
      echo $sql."<br>".$rsP->display().'<br>'.$conn->errHTML(); 



    $sql='SELECT * FROM Productos where proEstado="A" ';
    if($pcID) $sql.=" AND pcID=".$pcID." ";
     $sql.=" ORDER BY proTotComprado DESC ;";
      $rsP = $conn->execute($sql);
      if($debug) // DEBUG
        echo $sql."<br>".print_r($rsP,true).'<br>'.$conn->errHTML(); 
?>



<div class="container" style="padding-top: 1em;">

<div class="row">
<?
for( ; !$rsP->eof;$rsP->moveNext()){
?>



  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">

      <? 
      	if( $rsP->field('proFoto') ) {
      		echo '<img src="'.$rsP->field('proFoto').'" alt="'.$rsP->field('proDescrip').'" >';
      	}
      ?>
      <div class="caption">
        <h3><?= $rsP->field('proDescrip')?> $<?= $rsP->field('proPrecio')?></h3>
        <p><?= $rsP->field('proDetalle')?></p>
        <p>
          <a href="#" class="btn btn-primary" role="button">compartir</a>
          <a href="?<?= $rsP->field('proID')?>" class="btn btn-default" role="button">agregar</a>
        </p>
      </div>
    </div>
  </div>

<?
}
?>
</div>
</div>

<? /* CORTO EL ENVIO DE HTML


  /// EJEMPLOS CONSTRUCCION DE GRUILLA


<!--
	<section>
		<article></article>
	</section>


<li class="peyaCard product " data-id="2526912" data-options="1" data-autolink="promo-dos-hamburguesas-completas-papas-fritas-grandes" data-auto="shopdetails_product">
<input type="hidden" name="tags" value="" id="tags"/>
<input type="hidden" name="sectionTags" value="" id="sectionTags"/>
<h4 class="productName">Promo - Dos hamburguesas completas + papas fritas grandes</h4>
<div class="price">
<span>$229</span>
</div>
<b title="Agregar a mi pedido">+</b>
<p>Dos hamburguesas clásicas mas papas fritas.</p>
</li>
-->
<!-- EJEMPLO CAJAS
<div class="container" style="padding-top: 1em;">

  <div class="row">

    <div class="col-xs-4 col-md-4">
      <div class="thumbnail">
        <img data-src="holder.js/300x200" alt="Generic placeholder thumbnail" src="data:image/png;base64,">
        <div class="caption">
          <h3>Título de la imagen</h3>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
          <p><a href="#" class="btn btn-primary" role="button">Botón</a> <a href="#" class="btn btn-default" role="button">Botón</a></p>
        </div>
      </div>
    </div>
    <div class="col-xs-4 col-md-4">
      <div class="thumbnail">
        <img data-src="holder.js/300x200" alt="Generic placeholder thumbnail" src="data:image/png;base64,">
        <div class="caption">
          <h3>Título de la imagen</h3>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
          <p><a href="#" class="btn btn-primary" role="button">Botón</a> <a href="#" class="btn btn-default" role="button">Botón</a></p>
        </div>
      </div>
    </div>
    <div class="col-xs-4 col-md-4">
      <div class="thumbnail">
        <img data-src="holder.js/300x200" alt="Generic placeholder thumbnail" src="data:image/png;base64,">
        <div class="caption">
          <h3>Título de la imagen</h3>
          <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p>
          <p><a href="#" class="btn btn-primary" role="button">Botón</a> <a href="#" class="btn btn-default" role="button">Botón</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
--> */