<?php
require_once './classes/ConexaoBD.php';
$userBD = new UsuarioBD();
if (isset($_COOKIE['userBD'])) {
    $userBD->getUsuarioFromXml($_COOKIE['userBD']);
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>Projeto Final</title>

        <link rel="stylesheet" href="stylesheets/styles.css">
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="stylesheets/pygment_trac.css">
        <script src="javascripts/scale.fix.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="slimbox2.js"></script>
	<link rel="stylesheet" href="stylesheets/slimbox2.css" type="text/css" media="screen" />
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">
            $(document).ready(function() {
                //alert('ola');

            });

            $(document).ready(function() {
                $.getJSON('buscaUsuario.php', function(data) {
                    var cliente = [];
                    $(data).each(function(key, value) {
                        for (var j in value.busca)
                            cliente.push(value.busca[j].user_nick);
                    });
                    $('#inputbusca').autocomplete({source: cliente, minLength: 3});
                });
            });


            function postMsg() {
                $('<input />').attr('type', 'hidden')
                        .attr('name', 'msg_user_id')
                        .attr('value', "<?php echo $userBD->user_id ?>")
                        .appendTo('#form');

                $.post('menssagensexec.php',
                        $('#form').serialize(),
                        function(r) {
                            if (r.inserido)
                                alert('Ok');
                            else
                                alert(r.erro);
                        }, 'json');
            }

            function logout()
            {
                document.cookie = 'userBD=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
                window.location.href = "./index.php";
            }

            var auto_refresh = setInterval(
                    function()
                    {
                        $('#mensagens').load('menssagensexec.php').fadeIn("slow");
                    }, 10000);

        </script>
    </head>
    <body>
        <div id="tfheader">
            <form id="tfnewsearch" method="post" action="">
                <input id="inputbusca" type="text" class="inputbusca" name="q" size="21" maxlength="120">
                <input type="button" rel="lightbox" value="buscar"  onclick="buscarUsuario();" class="tfbutton">
            </form>
            <div class="tfclear"></div>
        </div>
        <div class="wrapper">
            <header>
                <h1 class="header"><?php echo $userBD->user_nick; ?></h1>
                <ul>
                    <li class="download"><a class="buttons">HOME</a></li>
                    <li class="buttons"><a href="images/user.jpg" class="buttons" rel="lightbox" title="Perfil">PERFIL</a></li>
                    <li class="buttons"><a class="buttons" title="Mensagens">MENSAGENS</a></li>
                    <li><a class="buttons" title="Logout" onclick="logout();">LOGOUT</a></li>
                </ul>
            </header>
            <section>
                <h3>Timeline</h3>
                <form method="post" id="form">
                    <input type="text" id="txtMsg" name="txtMsg" placeholder="No que você está pensando?"
                           style=" background-color: transparent; border-style: solid; border-width: 0px 0px 1px 0px; border-color: darkred; width: 100%;"/>
                    <input type="hidden" name="tipo" value="addMSG">
                    <input type="button" onclick="postMsg();" id="btPostar" name="btPostar" value="Publicar"
                           style=""/>
                </form>
                <div class="mensagens" id="mensagens" onload="ajax();">
                    <pre>Teste msg</pre>
                </div>
            </section>
        </div>
        <!--[if !IE]><script>fixScale(document);</script><![endif]-->
    </body>
    <script type="text/javascript">
        
        function buscarUsuario() {
                $.post('buscaUsuario.php',
                        $('#tfnewsearch').serialize(),
                        function(r) {
                            if (r.busca)
                                mostraUsuarios(r.busca);
                            else
                                alert(r.erro);
                        }, 'json');
            }
            function mostraUsuarios(usuarios) {
                var d = document;
                var b = d.getElementsByTagName('body')[0];
                var dvs = d.createElement("div");
                var bt = d.createElement("button");
                var t = d.createTextNode("Fechar");
                var texto = d.createTextNode(usuarios);
                dvs.appendChild(texto);
                bt.appendChild(t);
                dvs.appendChild(bt);
                dvs.className = "test";
                b.appendChild(dvs);
                bt.onblur = function(e) {
                    op(this.parentNode)
                }
                function op(t) {
                    alert('onblur');
                }

            }
        
        </script>
</html>
