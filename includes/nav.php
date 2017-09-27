<?

    // DEFINIR
$pcID = isset($_GET['pcID']) ? $_GET['pcID'] : 0;

// pasar a libreria
$sql='SELECT * FROM ProductosCategorias WHERE pcEstado="A";';
$rsPC = $conn->execute($sql);
if(isset($_GET['pcID']) && $_GET['pcID']) $pcID = $_GET['pcID']; else $pcID=0;

?>

<nav role="navigation" class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle"> 
            <DIV>menu</DIV> 
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="." class="navbar-brand">Pan & Queso</a>
        </div>

        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <? 
                for( ; !$rsPC->eof ; $rsPC->moveNext() ){
                  echo '<li '. ( $pcID==$rsPC->field('pcID') ? 'class="active"':'' ) .'><a href="?pcID='.$rsPC->field('pcID').'">'.$rsPC->field('pcDescrip').'</a></li>';
                }
                ?>

                <!-- MENU DESPLEGABLE X AHORA NO SE USA
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#>Acerca de <b class="caret"></b></a>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#">Quienes somos</a></li>
                        <li><a href="#">Ubicación</a></li>
                        <li><a href="#">Historia</a></li>
                    </ul>
                </li> 
                -->
            </ul>
            <form method="GET" role="search" class="navbar-form navbar-right">
               <div class="form-group">
                    <input type="text" placeholder="Buscar" class="form-control">
               </div>
           </form>

        </div>
    </nav>