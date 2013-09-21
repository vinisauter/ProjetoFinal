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
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="wrapper">
            <header>
                <h1 class="header">Login</h1>

<form method="post" action="index.html" class="login">
    <p>
      <label for="login">E-mail:</label>
      <input type="text" name="login" id="login" placeholder="exemplo@email.com">
    </p>

    <p>
      <label for="password">Senha:</label>
      <input type="password" name="password" id="password" placeholder="**********">
    </p>
    <input type="checkbox" id="lembrar"/> <label for="lembrar">Continuar conectado</label><br/>
    <a href="index.html">Esqueceu a sua senha?</a>
    <p class="login-submit">
      <button type="submit" class="login-button">Login</button>
      <button type="button" class="cadastro-button" onclick="location.href='cadastro.html'">Cadastrar</button>     
    </p>
 </form>
                
            </header>
            
            <section>
                <h3>Bem-vindo ao Profim. </h3>

                 <p> Texto blablabla  </p>
            </section>
        </div>
        <!--[if !IE]><script>fixScale(document);</script><![endif]-->
        <?php
        require_once './classes/ConexaoBD.php';
        $userBD = new UsuarioBD();
        
        var_dump($userBD->getUsuarioBanco());
        ?>
    </body>
</html>
