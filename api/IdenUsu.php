<html>
<head>
    <title>Identificación</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <SCRIPT SRC="../scripts/consejeria/cifrado.js"></SCRIPT>
    
    <script type="text/javascript">
    function comprobarclave(){
        var form = document.forms['FORMULARIO_IDEN_USU'];
        if(form['USUARIO'].value == "") {
            alert("El campo 'Usuario' es obligatorio");
        } else if(form['CLAVE'].value == "") {
            alert("El campo 'Clave' es obligatorio");
        } else {
            // Ciframos la clave antes de enviar (como pedía tu código original)
            form['CLAVECIFRADA'].value = cifrar(form['CLAVE'].value);
            // Limpiamos el campo original por seguridad
            form['CLAVE'].value = "";
            form.submit();
        }
    }
    </script>
    <style>
.morado {
	background-color: #9A6289
}

.blanco {
	background-color: #FFFFFF
}

.lila {
	background-color: #BE9BB4
}

.moradoclaro {
	background-color: #DBC6D4
}

.verdeagua {
	background-color: #B7DDC8
}

.verde {
	background-color: #B3D76B
}

.naranja {
	background-color: #EAB863
}

.botones {
	background-color: #FFFFFF;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	border: 1px #6B4560 solid;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8pt;
	font-weight: normal;
	color: #000000;
	width: 100px;
	text-decoration: none
}

.botones:hover {
	background-color: #DDCAD8;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	border: 1px #6B4560 solid;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8pt;
	font-weight: normal;
	color: #5A3A51;
	text-decoration: none;
}

input {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8pt;
	font-weight: bold;
	color: #573957;
	text-decoration: none;
	background-color: #DBC6D4;
	border: #FFFFFF;
	border-style: solid;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px
}

.input_check {
	background-color: transparent;
	border: none;
}

.usuario {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9pt;
	font-weight: bold;
	color: #FFFFFF;
	text-decoration: none
}

.usuarioMostrar {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9pt;
	font-weight: bold;
	color: #B3D76B;
	text-decoration: none
}

.mensaje {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12pt;
	font-weight: bold;
	color: #E8FF48;
	text-decoration: none
}

.botones2 {
	background-color: #F0AA94;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	text-align: center;
	border: 1px #E77551 solid;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8pt;
	font-weight: bold;
	color: #903214;
	width: 100px;
	text-decoration: none
}

.botones2:hover {
	background-color: #B3D76B;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	border: 1px solid;
	text-align: center;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 8pt;
	font-weight: bold;
	color: #000000;
	text-decoration: none;
	border-color: #799F2B #669933 #669933
}

.titulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;
	color: #FFFFFF;
	text-decoration: none;
	background-color: #9A6289;
	width: 100%;
	padding-left: 10px
}

.txtblanco {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	text-align: justify;
	font-weight: normal;
	color: #FFFFFF;
	text-decoration: none;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 10px
}

.txtpositivo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;
	color: #FFFFFF;
	text-decoration: none;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 10px
}

.txtidentificacion {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: bold;
	color: #DBC6D4;
	text-decoration: none;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 10px
}

.txtmensajeerror {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt;
	font-weight: normal;
	color: #FF9900;
	text-decoration: none;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 10px;
	text-align: justify;
}

.lista {
	background-image: url(secretaria_on.gif);
	background-repeat: no-repeat;
	background-position: 5px 5px
}

.txtcabecera {
	font-family: impact, Arial, Helvetica, sans-serif;
	background-color: #8D5A7E;
	color: #FFFFFF;
	font-size: 18pt
}

.blanco a {
	color: #B3D76B;
	font-family: tahoma;
	font-size: 14pt;
	text-decoration: none;
}

.txtmensajeerror
{
	color:#FF9900;
	font-family:Arial,Helvetica,sans-serif;
	font-size:10pt;
	font-weight:normal;
	padding:4px 4px 4px 10px;
	text-align:justify;
	text-decoration:none;
}
    </style>
</head>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff">
    <td class="morado" height="165" valign="top" width="30%">
        <table align="center" border="0" cellpadding="0" cellspacing="5" width="90%">
            <tbody>
                <tr>
                    <td>
                        <form name="FORMULARIO_IDEN_USU" method="POST" action="ComprobarUsuario.php">
                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr align="center">
                                        <td class="usuario" height="31" valign="middle">
                                            Usuario <br>
                                            <input name="USUARIO" value="" size="20" type="text">
                                        </td>
                                    </tr>
                                    <tr align="center">
                                        <td class="usuario">
                                            Contraseña<br>
                                            <input name="CLAVE" value="" size="20" type="password">
                                            <input name="CLAVECIFRADA" value="" type="hidden">
                                        </td>
                                    </tr>
                                    <tr align="center">
                                        <td>
                                            <br>
                                            <a href="javascript:comprobarclave();" class="botones2">
                                                &nbsp;&nbsp;&nbsp;Entrar&nbsp;&nbsp;&nbsp;
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
    </body>
</html>
