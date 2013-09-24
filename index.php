<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <title>Projeto Final</title>

        <link rel="stylesheet" href="stylesheets/styles.css">
        <link rel="stylesheet" href="stylesheets/pygment_trac.css">
        <script src="javascripts/scale.fix.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="wrapper">
            <header>
                <h1 class="header">Login</h1>
                <form action="" method="post" id="instantform">
                    <p>
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" />
                    </p>
                    <p>
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" />
                    </p>
                    <button type="button" class="cadastro-button" onclick="location.href = 'cadastro.html'">Cadastrar</button>     
                </form>
                <div id="loader"><img src="images/fbloader.gif" alt="carregando…" /></div>
                <div id="results"></div>

            </header>

            <section>
                <h3>Bem-vindo ao Profim. </h3>

                                 <p> Texto blablabla  </p>
            </section>
        </div>
        <!--[if !IE]><script>fixScale(document);</script><![endif]-->
        <script type="text/javascript">
                        $(document).ready(function() {
                            $("#loader").hide();

                            $("#password, #username").keyup(function() {
                                var passnum = $("#password").val();
                                var usernum = $("#username").val();

                                if (passnum.length >= 4 && usernum.length >= 4) {
                                    var qry = 'username=' + $("#username").val() + '&password=' + passnum;

                                    if ($("#loader").attr("class") != "loading") {
                                        $("#loader").addClass("loading");
                                        $("#loader").show();
                                    }

                                    $.ajax({
                                        type: "POST",
                                        url: "login.php",
                                        data: qry,
                                        success: function(html) {
                                            if (html == 'true') {
                                                $("#loader").hide();
                                                $("#instantform").fadeOut(1100, 'swing');
                                                $("#results").append('Sucesso! Logado como <strong>' + usernum + '</strong>!!');
                                                $("#loader > img").attr("src", "images/checkmark.png");
                                                $("#loader").fadeIn(800);
//TODO:		
window.location.href = "./perfil.html";  
                                            }
                                            else {
                                                // 
                                            }
                                        }
                                    });
                                }
                            });
                        });
        </script>
    </body>
</html>
