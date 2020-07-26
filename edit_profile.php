<?php
date_default_timezone_set('America/Sao_Paulo');//date_default_timezone_set('Asia/Tokyo');
if (version_compare(phpversion(), "5.3.0", ">=")  == 1){
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	} else {
		error_reporting(E_ALL & ~E_NOTICE);
	}
	
require_once('./include/membersite_config.php');
include_once('config_class.php');

	if(!$fgmembersite->CheckLogin())
	{
    $fgmembersite->RedirectToURL('index.php');
    exit();
	}

	$EditUserProfile = new EditUserProfile();
	$UserProfile = new UserProfile();
	$GetAgendaDatetime = new GetAgendaDatetime();
	$GetStartTime = $EditUserProfile->EditUserProfileAgendaStartTime($EditUserProfile->phone, date('Y-m-d'));
	$GetEndTime = $EditUserProfile->EditUserProfileAgendaEndTime($EditUserProfile->phone, date('Y-m-d'));	

	if(isset($_GET['acao'])){
		if($_GET['acao'] == 'add'){
			$id = intval($_GET['id']);
			if(!isset($_SESSION['carrinho'][$id])){
				$_SESSION['carrinho'][$id] = 1;
			}
			else {
				$_SESSION['carrinho'][$id] += 1;
			}
		}
		//REMOVER CARRINHO
		if($_GET['acao'] == 'del'){
			$id = intval($_GET['id']);
			if(isset($_SESSION['carrinho'][$id])){
				unset($_SESSION['carrinho'][$id]);
			}
		}
	}

	
require_once('classes/CMySQL.php'); // include service classes to work with database and comments
require_once('classes/CMyComments.php');

	if ($_POST['action'] == 'accept_comment') {
		echo $GLOBALS['MyComments']->acceptComment();
		exit;
	}
	
	// prepare a list with photos
	$user_gallery_phone_number = $UserProfilePage->phone;
	//$table_name = $user_gallery_phone_number."_photos";

	$table_name = 'gpappusergallery';

	$select_user_gallery = "SELECT id,filename FROM 'gallery_photos' WHERE phone='$EditUserProfile->phone' ORDER by 'initial_date' ASC";

	$sPhotos = '';
	
	$GetUserProfile = $EditUserProfile->phone;

	$aItems = $GLOBALS['MySQL']->getAll("SELECT id,filename FROM gpappusergallery WHERE phone='$GetUserProfile' ORDER by `initial_date` ASC"); // get photos info

	if ($_SESSION['id_of_user']==$_GET['id']){
		$GetUserProfile = $EditUserProfile->phone;
		$aItems = $GLOBALS['MySQL']->getAll("SELECT id,filename FROM gpappusergallery WHERE phone='$GetUserProfile' ORDER by `initial_date` ASC"); // get photos info
		foreach ($aItems as $i => $aItemInfo) {
		$sPhotos .=
			'<a href="images/'.$EditUserProfile->phone.'/'.$aItemInfo['filename'].'" class="highslide" onclick="return hs.expand(this)">
				<img src="images/'.$EditUserProfile->phone.'/thumb_'.$aItemInfo['filename'].'" height="170px" width="170px" id="'.$aItemInfo['id'].'" />
			</a>
			<div class="highslide-caption">
				&nbsp <span style="font-size:12px;"> www.gpapp.com.br filename : ['.$aItemInfo['filename'].' ]</span>
			</div>';
		}
	}else {
		$GetUserProfile = $UserProfile->phone;
		$aItems = $GLOBALS['MySQL']->getAll("SELECT id,filename FROM gpappusergallery WHERE phone='$GetUserProfile' ORDER by `initial_date` ASC"); // get photos info
		foreach ($aItems as $i => $aItemInfo) {				
		$sPhotos .=
			'<a href="images/'.$UserProfile->phone.'/'.$aItemInfo['filename'].'" class="highslide" onclick="return hs.expand(this)">
				<img src="images/'.$UserProfile->phone.'/thumb_'.$aItemInfo['filename'].'" height="170px" width="170px" id="'.$aItemInfo['id'].'" />
			</a>
			<div class="highslide-caption">
				text here
			</div>';
		}
	}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<title>MyApp profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/profile/style.css" />
		<!-- <link rel="stylesheet" type="text/css" href="css/profile/profile.css" /> -->
		<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
		<!-- Font Awesome edit icon-->
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<!-- highslide slide gallery -->
		<script type="text/javascript" src="highslide/highslide-full.js"></script>
		<script type="text/javascript">
		hs.graphicsDir = 'highslide/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		hs.fadeInOut = true;
		hs.dimmingOpacity = 0.75;

		// define the restraining box
		hs.useBox = true;
		hs.width = 640;
		hs.height = 580;

		// Add the controlbar
		hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
			overlayOptions: {
				opacity: 1,
				position: 'bottom center',
				hideOnMouseOut: true
			}
		});
		</script>
  <style type="text/css">
	@media only screen and (max-width: 400px) { .col-xs-4 { width: 50%; }}
	@media only screen and (max-width: 400px) { #mobile { width: 100%; }}
	.img-gal{ display: block; }
  </style>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
</head>
<body>
	<!--
	<div class="container-fluid">
	
		<h5><img height="20px" width="20px"> username lastname <span><small>+55(11)91234-5678.</small></span><a href="logout.php">Sair (Log Out)</a></h5>
		
	</div>
	-->
	
	<nav class="navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
				<a class="navbar-brand" href="#">
					<img alt="Brand" src="images/gpapplogo1.png" height="25px" style="margin-top:-3px;"/>
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li style="font-weight:bold;font-size:20px;"><a href="mainpage.php">uatiszap <span class="sr-only">(current)</span></a></li>
				</ul>
				<form class="navbar-form navbar-left">
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Search</button>
				</form>
				
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="profile.php?id=<?php echo $EditUserProfile->identification;?>" style="background-color:#FFFFFF;border:1px solid rgba(144,144,144,0.2);padding:5px 15px;border-radius:5px;margin-top:10px;">
							<img src="images/900000202/profile_thumbnail_app2.png" height="25px" alt="nil">&nbsp; <span>profile</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" style="width:150%;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							
							&nbsp; <span id="dropdown-username"><?php echo $EditUserProfile->username; ?></span> &nbsp; <span class="glyphicon glyphicon-menu-down"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="edit_profile.php?id=<?php echo $EditUserProfile->identification;?>" style="padding:10px;"><span class="glyphicon glyphicon-edit"></span> &nbsp; Edit Profile</a></li>
							<li><a href="#" style="padding:10px;"><span class="glyphicon glyphicon-usd"></span> &nbsp Payments</a></li>
							<li><a href="analytics_profile.php?id=<?php echo $EditUserProfile->identification;?>" style="padding:10px;"><span class="glyphicon glyphicon-stats"></span> &nbsp; Analytics <i style="font-size:11px;">(estat&iacutesticas)</i></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="logout.php" style="padding:10px;"><span class="glyphicon glyphicon-log-out"></span> &nbsp; Log Out <i style="font-size:11px;">(Sair)</i> </a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	

	<div class="row" style="background:rgba(144,144,144,0.075);border-top:1px solid rgba(144,144,144,0.5);">
		<div class="col-xs-3 col-sm-2 col-md-1"></div>
		<div class="col-md-5" style="border:1px dotted rgba(125,125,125,0.5);padding:2px;">
			<div class="parent">
				<div>
					<!--  <img class="img-responsive" src="images/900000202/cover_profile.png" style="margin:0 auto;">  -->
					
					<?php
						if ($_SESSION['id_of_user']==$_GET['id']){  ?>
						<div class="profile-pic">
						<?php echo $EditUserProfile->cover_profile_image; ?>
						<div class="edit"><a href="edit_profile.php?id=<?php echo $EditUserProfile->identification;?>"><i class="fa fa-camera fa-lg"></i></a></div>
						</div>
						<?php }
						else {  ?>
						<?php echo $UserProfile->cover_profile_image; ?>
						<?php
						}
					?>
					
				</div>
				<div style="margin:0 auto;padding:3%;border:1px solid rgba(144,144,144,0.25);background:#FFFFFF;">
					<table>
						<tr>
							<td>
								<img src="images/profile.jpg" class="img-thumbnail" style="height:100px;width:100px;">
							</td>
							<td>&nbsp;</td>
							<td>
								<form method="post" action="" id="ajax_form" class="form-style">
									
									
											<input id="input-username" type="text" name="username" value="<?php echo $EditUserProfile->username; ?>" />&nbsp;
									
											<br/>
											<input type="hidden" name="last-phone" value="<?php echo $EditUserProfile->phone; ?>" />
											<input id="input-phone" type="text" name="phone" value="<?php echo $EditUserProfile->phone; ?>" style="margin-top:3px;"/>
											&nbsp; <input id="input-submit" type="submit" name="enviar" value="Salvar" />
									
									
									<label><input type="hidden" name="id" value="" /></label>
								</form>
								<!--
								<form method="post" action="" id="ajax_form">
									<ul class="form-style-1">
										<li>
											<input id="input-username" style="width:200px;" type="text" name="username" value="<?php echo $EditUserProfile->username; ?>" />&nbsp;
										</li>
										<li>
											<input type="hidden" name="last-phone" value="<?php echo $EditUserProfile->phone; ?>" />
											<input id="input-phone" type="text" name="phone" value="<?php echo $EditUserProfile->phone; ?>" />
											&nbsp; <input id="input-submit" type="submit" name="enviar" value="Salvar" />
										</li>
									</ul>
									<label><input type="hidden" name="id" value="" /></label>
								</form>
								-->
								<script type="text/javascript">
								jQuery(document).ready(function(){
									navbarWidth = $('.col-md-1').width();
									var navBarMarginLeft = (navbarWidth-10);
									var navBarMarginRight = (navbarWidth*2);
									$('.navbar-brand').css('margin-left', navBarMarginLeft);
									$('.navbar-right').css('margin-right',navBarMarginRight);
									jQuery('#ajax_form').submit(function(){
										var dados = jQuery( this ).serialize();
										var edited_username = $('#input-username').val();
										var edited_phone = $('#input-phone').val();
										jQuery.ajax({
											type: "POST",
											url: "ajax_edit.php",
											data: dados,
											success: function( data )
											{
												alert( data );
												//jQuery('#input-nome').replaceWith($('#input-nome').val());
												jQuery('#input-username').replaceWith('<div class="itemsContainer"><div class="image"><a href="edit_profile.php?id='+<?php echo $EditUserProfile->identification; ?>+'"> '+edited_username+' </a></div><div class="play"><a href="edit_profile.php?id='+<?php echo $EditUserProfile->identification; ?>+'"><span class="fa fa-pencil fa-lg"></span></a></div></div>');
												jQuery('#input-phone').replaceWith('<div class="itemsContainer"><div class="image"><a href="edit_profile.php?id='+<?php echo $EditUserProfile->identification; ?>+'"> '+edited_phone+' </a></div><div class="play"><a href="edit_profile.php?id='+<?php echo $EditUserProfile->identification; ?>+'"><span class="fa fa-pencil fa-lg"></span></a></div></div>');
												jQuery('#input-submit').remove();
												jQuery('#dropdown-username').replaceWith(edited_username);
											}
										});
										return false;
									});
								});
								</script>
							</td>
							<td>
								
							</td>
						</tr>
						
					</table>
					
				</div>
			</div>
			
		</div>
		<div class="col-md-5" style="padding:2px;background:#FFFFFF;">
			<div style="font-family:Verdana, Geneva, sans-serif;font-size:12px;">
				<div class="col-xs-6 col-md-3">
					<?php echo "Idade : ".$EditUserProfile->age." anos"; ?>
				</div>
				<div class="col-xs-6 col-md-3">
					<?php echo "Altura : ".$EditUserProfile->height." m"; ?>
				</div>
				<div class="col-xs-6 col-md-3" style="border:1px dotted green;">
					<a href="#" data-toggle="tooltip" data-placement="right" title="edit"><?php echo "Weight : ".$EditUserProfile->weight." kg"; ?></a>
				</div>
				<div class="col-xs-6 col-md-3" style="border:1px dotted green;">1h : R$250</div>
			</div>
			
			<div id="img-gal" class="col-sm-3 col-xs-4 thumb" style="padding:2px;" > 
				<a href="#"> 
					<img class="img-responsive" src="http://placehold.it/200x200" alt=""> 
				</a> 
			</div>
			<div id="img-gal" class="col-sm-3 col-xs-4 thumb" style="padding:2px;" > 
				<a href="#"> 
					<img class="img-responsive" src="http://placehold.it/200x200" alt=""> 
				</a> 
			</div>
			<div id="img-gal" class="col-sm-3 col-xs-4 thumb" style="padding:2px;" > 
				<a href="#"> 
					<img class="img-responsive" src="http://placehold.it/200x200" alt=""> 
				</a> 
			</div>
			<div id="img-gal" class="col-sm-3 col-xs-4 thumb" style="padding:2px;" > 
				<a href="#"> 
					<img class="img-responsive" src="http://placehold.it/200x200" alt=""> 
				</a> 
			</div>
			
		</div>
		<div class="col-md-1" style="border:1px solid rgba(125,125,125,0.5)"></div>
	</div>
	
	<!--
	<div class="jumbotron text-center">
		<h4>Username lastname &nbsp <small>+55(11)91234-5678</small></h4>
	</div>
	-->
	
<div class="container" id="anchor-edit">
	
	<div class="panel panel-default" style="font-family:Verdana, Geneva, sans-serif;font-size:13px;margin-top:5px;padding:5px;">
		<form action="update_profile_description.php" method="post" enctype="multipart/form-data">
			<div class="row" style="border-top:1px solid  rgba(144,144,144,0.2);border-left:1px solid  rgba(144,144,144,0.2);border-right:1px solid  rgba(144,144,144,0.2);margin:0 auto;display:block;">
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">
					<?php
						// http:/  jsfiddle.net/Guruprasad_Rao/2s8yqys7/1/
						if ($_SESSION['id_of_user']==$_GET['id']){  ?>
							<?php //echo $EditUserProfile->username;
								echo
								'<div class="itemsContainer">
									<div class="image">
										Age : <input name="description01" type="text" value="'.$EditUserProfile->age.'" style="width:40px;border:1px solid #BEBEBE;padding:0 0 7px 3px;box-sizing: border-box;"> yr
									</div>
								</div>';
							?>
						<?php }
						else {  ?>
							<?php echo "Age : ".$UserProfile->age."yr";
							?>
						<?php
							}
					?>
				</div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">
					<?php
						// http:/  jsfiddle.net/Guruprasad_Rao/2s8yqys7/1/
						if ($_SESSION['id_of_user']==$_GET['id']){  ?>
							<?php //echo $EditUserProfile->username;
								echo
								'<div class="itemsContainer">
									<div class="image">
										Height : <input name="description02" type="text" value="'.$EditUserProfile->height.'" style="width:40px;border:1px solid #BEBEBE;padding:0 0 7px 3px;box-sizing: border-box;"> m
									</div>
								</div>';
							?>
						<?php }
						else {  ?>
							<?php echo "Height : ".$UserProfile->height." m";
							?>
						<?php
							}
					?>
				</div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">
					<?php
						// http:/  jsfiddle.net/Guruprasad_Rao/2s8yqys7/1/
						if ($_SESSION['id_of_user']==$_GET['id']){  ?>
							<?php //echo $EditUserProfile->username;
								echo
								'<div class="itemsContainer">
									<div class="image">
										Weight : <input name="description03" type="text" value="'.$EditUserProfile->weight.'" style="width:40px;border:1px solid #BEBEBE;padding:0 0 7px 3px;box-sizing: border-box;"> kg
									</div>
								</div>';
							?>
						<?php }
						else {  ?>
							<?php echo "Height : ".$UserProfile->weight." m";
							?>
						<?php
							}
					?>
				</div>
				<div class="col-xs-4 col-md-2 text-nowrap">description : <input name="description07" type="text" value="<?php echo "none"; ?>" style="width:40px;border:1px solid #BEBEBE;padding:0 0 7px 3px;box-sizing: border-box;" /> unit</div>
				<div class="col-xs-4 col-md-2 text-nowrap">description : <input name="description09" type="text" value="<?php echo "none"; ?>" style="width:40px;border:1px solid #BEBEBE;padding:0 0 7px 3px;box-sizing: border-box;" /> unit</div>
				<div class="col-xs-4 col-md-2 text-nowrap">Feet size : 37</div>
			</div>
		
			<div class="row" style="border-right:1px solid  rgba(144,144,144,0.2);border-left:1px solid  rgba(144,144,144,0.2);margin:0 auto;display:block;">
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">Allow smoke : Yes</div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile" style="background-color:lavender;">Price : R$250</div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">travel : available YES</div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">Do this : YES</div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">available : full time</div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile">available : full time</div>
			</div>
			
			<div class="row" style="border:1px solid rgba(144,144,144,0.2);margin:0 auto;display:block;">
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile"></div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile"></div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile"></div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile"></div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile"></div>
				<div class="col-xs-4 col-md-2 text-nowrap" id="mobile" style="padding:4px 0;">
					<input name="saveEdit" type="submit" value="Salvar" style="background: #4B99AD;padding: 0 6px;border: none;color:#FFFFFF;border-radius:3px;font-size: 11px;font-family: Lucida Sans Unicode;margin: 0 auto;display:block;">
				</div>
			</div>
			
		</form>
	</div>
	
	<div class="row">
		
		<div class="col-sm-4">
		  <h5>Agenda</h5>
		  <p>Joanin</p>
		  <p>Remenber : user gp block visitor by IP example...</p>
		  https://pt.m.xhamster.com/movies/7761313/aufgepumte_votze_geil.html *idea 20170531 make proteses imitate a pussy lips to put in entrance of vagina hooker estimulate man (client, customer)*
		</div>
		
		<div class="col-sm-6 col-md-6">
			<!--  <h6 >&nbsp Photo gallery</h6>  -->
			
			<div class="grid-gallery">
				<div class="caixaPhoto">
					<div class="conPhoto">
						<div class="pdPhoto">
							<div class="sharePhoto">Galeria de Foto </div>
							<div class="statusPhoto" ></div>
							<div class="loadingPhoto"></div>
						</div>
						<div class="img_topPhoto"></div>
						<div class="text_statusPhoto">
							<div id="two-column">

							</div>
						</div>
					</div>
				</div>
					<div class="container_sPhoto">
						<?php echo $sPhotos; ?>
					</div>
			</div>
		</div>
	</div>
</div>

<div id="gallery" class="container">
  <h5>Image Gallery</h5>
  <p>The .thumbnail class can be used to display an image gallery. Click on the images to see it in full size:</p>            
  <div class="row">
    <div class="col-md-3">
      <a href="pulpitrock.jpg" class="thumbnail">
        <p>Agenda</p>    
        <img src="pulpitrock.jpg" alt="Pulpit Rock" style="width:150px;height:150px">
      </a>
    </div>
    <div class="col-md-5">
      <a href="moustiers-sainte-marie.jpg" class="thumbnail">
        <p>Main Photo Gallery</p>
			
      </a>
    </div>
    <div class="col-md-4">
      <a href="cinqueterre.jpg" class="thumbnail">
        <p>Maps, Services</p>      
        <img src="cinqueterre.jpg" alt="Cinque Terre" style="width:150px;height:150px">
      </a>
    </div>
  </div>
</div>
	
</body>
</html>