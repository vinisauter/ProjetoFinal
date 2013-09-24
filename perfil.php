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
        <link rel="stylesheet" href="stylesheets/pygment_trac.css">
        <script src="javascripts/scale.fix.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="tfheader">
            <form id="tfnewsearch" method="get" action="">
                <input type="text" class="tftextinput" name="q" size="21" maxlength="120">
                <input type="submit" value="buscar"  onclick="ajax();" class="tfbutton">
            </form>
            <div class="tfclear"></div>
        </div>
        <div class="wrapper">
            <header>
                <h1 class="header"><?php echo $userBD->user_nick; ?></h1>
                <ul>
                    <li class="download"><a class="buttons">HOME</a></li>
                    <li class="download"><a class="buttons">MENSAGENS</a></li>
                    <li><a class="buttons" onclick="logout();">LOGOUT</a></li>
                </ul>
            </header>
            <section>
                <h3>
                    <a class="anchor"><span class=""></span></a>Timeline</h3>

                <pre><code>
$ cd your_repo_root/repo_name
$ git fetch origin
$ git checkout gh-pages
                </code></pre>
            </section>
        </div>
        <!--[if !IE]><script>fixScale(document);</script><![endif]-->
        <script type="text/javascript">
                    $(document).ready(function() {
                        //alert('ola');

                    });
                    function logout()
                    {
                        document.cookie = 'userBD=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
                        window.location.href = "./index.php";
                    }

var page = "online.php";
function ajax(url,target) {
  // native XMLHttpRequest object
  document.getElementById(target).innerHTML = 'Loading...';
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = function() {ajaxDone(target);};
    req.open("GET", url, true);
    req.send(null);
    // IE/Windows ActiveX version
  } else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLDOM");
    if (req) {
      req.onreadystatechange = function() {ajaxDone(target);};
      req.open("GET", url, true);
      req.send(null);
    }
  }
  setTimeout("ajax(page,'scriptoutput')", 5000);
}

function ajaxDone(target) {
  // only if req is "loaded"
  if (req.readyState == 4) {
    // only if "OK"
    if (req.status == 200 || req.status == 304) {
      results = req.responseText;
      document.getElementById(target).innerHTML = results;
    } else {
      document.getElementById(target).innerHTML="ajax error:\n" +
      req.statusText;
    }
  }
}
        </script>
    </body>
</html>
