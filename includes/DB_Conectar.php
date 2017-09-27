<?
if(in_array($_SERVER['HTTP_HOST'],array('localhost','192.168.1.18') ) ) $i = 1;
else $i=0;

//************************* DECLARACION DE CONECCION ******************************//
$con_server[0]	= "192.168.1.25"; //	externa not jet
$con_dbase[0]    = "panyqueso";
$con_userid[0]   = "panyqueso";
$con_password[0] = "panyqueso";
//*********************************************************************************//
$con_server[1]	= "192.168.1.18"; //localhost
$con_dbase[1]    = "panyqueso";
$con_userid[1]   = "panyqueso"; //"argentonresObras";
$con_password[1] = "panyqueso";//;"lalalala908324"; 
//*********************************************************************************//

//******************************** INCLUDES ***************************************//
include("DB_MySQL.php");	 
//*********************************************************************************//

//***************************** CONEXION  *****************************************//
$conn=new TConnection; 
$conn->Connect($con_server[$i], $con_userid[$i], $con_password[$i], $con_dbase[$i]);
//*******************************************************************************//
?>