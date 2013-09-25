<?php
require_once './classes/ConexaoBD.php';
$userBD = new UsuarioBD();
if (isset($_COOKIE['userBD'])) {
    $userBD->getUsuarioFromXml($_COOKIE['userBD']);
} else {
    header("Location: index.php");
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
        <script type="text/javascript" src="javascripts/slimbox2.js"></script>
        <link rel="stylesheet" href="stylesheets/slimbox2.css" type="text/css" media="screen" />
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">
            $(document).ready(function() {
                $('#mensagens').load('menssagensexec.php').fadeIn("slow");
                $("#loader").hide();
                $.getJSON('buscaUsuario.php', function(data) {
                    var cliente = [];
                    $(data).each(function(key, value) {
                        for (var j in value.busca)
                            //`user_nome`, `user_nick`, `user_email`, `user_senha`, `user_sexo`
                            cliente.push(value.busca[j].user_nick.concat('(', value.busca[j].user_nome, ')'));
                    });
                    $('#inputbusca').autocomplete({source: cliente, minLength: 3});
                });
            });

            $(function() {
                $("#sortable1, #sortable2").sortable({
                    connectWith: ".connectedSortable"
                }).disableSelection();
            });

            function postMsg() {
                $("#loader").show();
                $('<input />').attr('type', 'hidden')
                        .attr('name', 'msg_user_id')
                        .attr('value', "<?php echo $userBD->user_id ?>")
                        .appendTo('#form');

                $.post('menssagensexec.php',
                        $('#form').serialize(),
                        function(r) {
                            if (r.inserido) {
                                $('#mensagens').load('menssagensexec.php').fadeIn("slow");
                                $("#loader").hide();
                                $('#txtMsg').val('');
                            }
                            else
                                alert(r.erro);
                        }, 'json');
            }

            function logout()
            {
                document.cookie = 'userBD=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
                window.location.href = "./index.php";
            }

            function buscarUsuario() {
                $('<input />').attr('type', 'hidden')
                        .attr('name', 'nick')
                        .attr('value', document.getElementsByTagName("input")[0].value.split("(")[0])
                        .appendTo('#tfnewsearch');
                $.post('buscaUsuario.php',
                        $('#tfnewsearch').serialize(),
                        function(value) {
                            if (!value.erro)
                                mostraUsuarios(value.busca);
                            else
                                alert(value.erro);
                        }, 'json');
            }
            function mostraUsuarios(values) {
                document.getElementById("blockBackgound").style.display = "block";
                var r = document.getElementById("nick");
                var t = document.createTextNode('Username: ' + values.user_nick);
                r.appendChild(t);
                var r = document.getElementById("nome");
                var t = document.createTextNode('Nome: ' + values.user_nome);
                r.appendChild(t);
                var r = document.getElementById("email");
                var t = document.createTextNode('E-mail: ' + values.user_email);
                r.appendChild(t);
                var r = document.getElementById("sexo");
                var t = document.createTextNode('Sexo: ' + values.user_sexo);
                r.appendChild(t);
            }

            var auto_refresh = setInterval(function()
            {
                $('#mensagens').load('menssagensexec.php').fadeIn("slow");
            }, 1000);

            function fecharA() {
                document.getElementById("blockBackgound").style.display = "none";
            }

        </script>
    </head>
    <body>
        <div id="blockBackgound" style="
             position:absolute; 
             top:0; 
             left:0; 
             background-color:rgba(0,0,0,0.7);
             width:100%; 
             height:100%; 
             display:none;
             z-index: 3333333">         
            <div id="dialogo" style="
                 position:absolute;
                 background-color:#f9f9f9; 
                 width:50%; 
                 height:50%;
                 top: 25%;
                 left: 25%;
                 border:2px solid #999999;
                 padding: 2px;">
                <img src="http://www.sensacionalista.com.br/wp-content/uploads/2013/04/Fake-Hair-Obama.jpg" style="width: 70px; height: auto;"/>
                <div><label id="nome"></label></div>
                <div><label id="nick"></label></div>
                <div><label id="email"></label></div>
                <div><label id="sexo"></label></div>
                <a id="btFecharDialog" onclick="fecharA();">Fechar</a>
            </div>
        </div>
        <div id="tfheader">
            <form id="tfnewsearch" method="post" action="">
                <input id="inputbusca" type="text" class="inputbusca" name="q" size="21" maxlength="120">
                <input type="button" value="Buscar" onclick="buscarUsuario();" class="tfbutton">

            </form>
            <div class="tfclear"></div>
        </div>
        <div class="wrapper">
            <header>
                <h1 class="header"><?php echo $userBD->user_nick; ?></h1>
                <ul id="sortable1" class="connectedSortable">
                    <li class="download"><a class="buttons">HOME</a></li>
                    <li class="buttons"><a href="http://www.sensacionalista.com.br/wp-content/uploads/2013/04/Fake-Hair-Obama.jpg" class="buttons" rel="lightbox" title="<?php echo $userBD->user_nome ?>">PERFIL</a></li>
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
                    <a id="loader"> <img src="images/fbloader.gif" alt="carregando…" style="margin: 0px 0px 0px 0px;"/> </a>
                </form>
                <div class="mensagens" id="mensagens" onload="ajax();">
                    <pre>Teste msg</pre>
                </div>
            </section>
        </div>
        <!--[if !IE]><script>fixScale(document);</script><![endif]-->
    </body>
</html>