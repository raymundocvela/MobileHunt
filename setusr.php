<?php if (!isset($_SESSION))session_start(); else echo "sesión iniciada"; ?>
<!--iniciamos variables de sessión-->
//2 setusr : 3 getpuntos
<!DOCTYPE html>
<html> <!--style="height:100%" es para poder ocupar el porcentaje en el div del mapa, si no se pone el div q se genera es de altura � height 0-->
    <head>
        <meta charset="utf-8" />
        <!--Calendario-->
        <link rel="stylesheet" href="build/kalendae.css" type="text/css" charset="utf-8">
        <script src="build/kalendae.js" type="text/javascript" charset="utf-8"></script>
        <!-- Script para desplegar calendario-->
        <script type="text/javascript" src="/js/popcalendar.js">        </script> 
        <script type="text/javascript">

                    
            function validar(){
                fecha=document.frmUsr.fecha.value
                if(fecha!="" && fecha.length==10 && fecha.charAt(2)=='-' && fecha.charAt(5)=='-'){
                return true;  
            } 
            else{
                alert("Debes ingresar una fecha con el formato dd-mm-aaaa (ejemplo: 07-07-2012)-"+fecha.charAt(3)+"-"+fecha.charAt(6) )
                //document.frmUsr.fecha.backgroundColor("CCFFCC")
                document.frmUsr.fecha.focus()
                return false;
            }
            }
        </script>
        <title> Mobile Hunt - Proyecto Terminal Ingeniería en Computación UAM Azcapotzalco</title>
    </head>
    <body>
        <form name="frmUsr" id="frmUsr" action="getpuntosgl_1.php" onsubmit="return validar()" method="get">
            <?php 
                include('conectar.php');
                include('deletefile.php');
                $file='/home/aiturbe/public_html/raymundo/files/ruta.kml';
                delete($file);
                //obtener menor año de los datos de posiciones
                //CAMBIAR CUANDO DB fecha este bien         
                //$query=mysql_query("SELECT MIN(YEAR(fecha)) FROM puntos ") or die("error".mysql_error());
                $query=mysql_query("SELECT MAX(YEAR(fecha)) FROM puntos ") or die("error".mysql_error());
                $rowYear=mysql_fetch_array($query);
                $minYear=$rowYear[0];
                echo'<a href="javascript:history.go(-1)">&lt&ltatrás</a>';
                echo"<br>año min $minYear <br>";
                //adecuar valor idIns
                $idInsti=$_REQUEST['ins']+1;
                $_SESSION["idInsti"]=$idInsti;
                echo $_SESSION['idInsti'];
                //obtener nombre Insti
                $result=mysql_query("SELECT nombre FROM institucion WHERE idinstitucion='".$idInsti."'") or die("error".mysql_error());
                $row=mysql_fetch_array($result);
                $nomInsti=$row[0];
                $_SESSION["nomInsti"]=$nomInsti;
                //usuarios segun idinstitucion
                $result=mysql_query("SELECT idusuarios,usuario FROM usuarios WHERE institucion_idinstitucion='".$idInsti."'") or die("error".mysql_error());                                    
                $option="";
                while ($row=mysql_fetch_array($result)){
                    $option=$option."<option value='$row[0]'>$row[0] $row[1]</option>";
                }
                echo"Institucion/Compania:<br> <input type='text' name='nomInsti' id='nomInsti' disabled='disabled' value='$nomInsti'/><br><br>";
                echo" Elige Usuario:<br> <select name='usr' id='usr' >$option</select><br><br>";
                //pasamos variable de php a javascript           
                echo 
                "<script languaje='JavaScript'>
                var minYear='".$minYear."';
                </script>";
                mysql_close($con);                
            ?>
            Día (dd-mm-aaaa)<br>
            <input type="text" required="required" name="fecha" id="dateArrival" class="auto-kal" data-kal="format:'DD-MM-YYYY', weekStart:'1', selected:Kalendae.moment()" size="10"><br><br>
                <!--
            <input name="fecha" type="text" id="dateArrival" onClick="popUpCalendar(this, frmUsr.dateArrival, 'dd-mm-yyyy',minYear);" size="10" ><br><br>
            -->
            <input type="submit" value="aceptar" align="center" />
        </form>
    </body>
</html>    