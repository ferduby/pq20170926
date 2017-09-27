<?

  // PASAR A LIBRERIA


    // GET Puntos Entrega
	$debug=0;
    $sql='SELECT *, date_format(hoEnHora,"%H:%i") hoEnHoraFormat 
      FROM  HorariosEntrega HE
      WHERE HE.hoEnEstado="A" AND HE.hoEnHora>NOW() ';
    $rsHE = $conn->execute($sql);
    if($debug) // DEBUG
      	echo $conn->errHTML() . $rsHE->display(); 
?>

<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" 
          data-toggle="dropdown" aria-expanded="true">
    Horario Entrega
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
  <? 
    for( ; !$rsHE->eof;$rsHE->moveNext()){
      echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="#">'.$rsHE->field('hoEnHoraFormat').'</a></li>';
    }
  ?>
  </ul>
</div>