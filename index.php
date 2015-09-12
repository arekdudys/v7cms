<?php
ob_start();
require('_inc/config.php');
require('_inc/functions.php');

function getXML($file) {
	if (file_exists($file)){
		$data = simplexml_load_file($file);
		return $data;
	}
	else{
		header("Location: ".base."404");
	}
}

if(isset($_GET['page'])){
    $getData=getXML(datadir.strip_tags($_GET['page']).'.xml');
    define('curpath',strip_tags($_GET['page']));
    define('curpage',str_replace('/','-',strip_tags($_GET['page'])));
}else{
    $getData=getXML(datadir.'index.xml');
    define('curpath','index');
    define('curpage','index');
}

$title       = $getData->title;
$date        = $getData->date;
$keywords    = $getData->keywords;
$description = $getData->description;
$url         = $getData->url;
$content     = stripslashes(html_entity_decode($getData->content, ENT_NOQUOTES, 'UTF-8'))

?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8">
	<base href="<?=base?>">
  <title><?=$title?> - <?=sitename?></title>
	<meta name="title" content="" />
  <meta name="description" content="<?=$description?>" />
	<meta name="keywords" content="<?=$keywords?>" />
  <meta name="author" content="Nettside.eu Eagle" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <meta name = "format-detection" content = "telephone=no" />
	
  <link rel="stylesheet" href="_css/style.css" />
	<script src="_js/jquery-1.8.3.min.js"></script>
	<script src="_js/responsiveslides.min.js"></script>
	<script src="_js/superfish.js"></script>
	<script src="_js/script.js"></script> 
	<script>
  $(function() {
    $("#slider").responsiveSlides();
  });
	</script>
	
	<meta name="google-site-verification" content="" />
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
	
	<link rel="shortcut icon" href="_img/favicon.ico" />
</head>
<body id="page-<?=curpage?>">

<header>
	<div class="inner">
		<a href='<?=base?>' id='logo' title='V7'><img src='_img/logo.png' alt='V7CMS'></a>
	</div>
</header>
	<nav>
		<div class="inner">
			<?php include('_cache/menu.html'); ?>
		</div>
	</nav>

<?php
if(curpage=='index'){
?>

	<ul id="slider">
		<li>
			<img src="_img/slide1.jpg" alt="">
			<p>Donec id elit non mi <b>porta</b> gravida at eget metus.</p>
			<span>Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas <b>porta</b> malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna.</span>
			</li>
		<li>
			<img src="_img/slide2.jpg" alt="">
			<p>Donec id elit non mi porta <b>gravida</b> at eget loremi metus.</p>
			<span>Vestibulum commodo volutpat a, convallis ac, <b>porta</b> laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna.</span>
		</li>
	</ul>
<?php
}
?>
	
  <div id="boxes">
  </div>
	

<section>
	<div class="inner">
    <h1><?=$title?></h1>
    <h4><?=$url?></h4>
    <h5><?=curpage?></h5>
    <h6><?=curpath?></h6>

<?php

if(defined('components')){

function getcomponent($source){
    $get = stripslashes(getXML(datadir.'_component/'.$source.'.xml')->content);
    $getcomp = create_function("",' ?>'.$get.'<?php ');
    ob_start();
    $getcomp();
    return ob_get_clean();
}
  preg_match_all("/\{\# (.*?) \#\}/",$content,$content3);
  foreach ($content3[1] as $value) { //$content3[0]
    $content2 = preg_replace("/\{\# ".$value." \#\}/",getcomponent($value),$content);
    $content = $content2;
  }
}
?>

<?=$content?>

</div>
</section>

  <div id="logos">
  </div>

<footer>
	<div class="inner">
		&copy; 2014 <b><?=sitename?></b> <?=adminemail?>
	</div>
</footer>

</body>
</html>
