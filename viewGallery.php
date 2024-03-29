<?php
session_start();
$sessionID = session_id(); 

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> Put into HTACCESS-->

	<title>Bren's Test Site</title>

	<meta name="author" content="Bren's Template Site" />
	<meta name="description" content="A simple template Site" />
    <meta name="keywords" content="HTML, Javascript, jQuery, CSS, CSS3, less.js" />
    
	<meta property="og:site_name" content="Bren's Website"/> <!-- Website Title -->
	<meta property="og:title" content="Bren's Template Site" /> <!-- Page Title -->
    <meta property="og:type" content="website" /> <!--Type of page -->
    <meta property="og:image" content="theme/touch-icon-iphone4.png" /> <!-- Image shown -->
	
    <meta property="og:url" content="http://bren1818.kicks-ass.net/"/> <!-- canonical link to this page -->
	<link rel="canonical" href="http://bren1818.kicks-ass.net/" /> <!-- canonical link to this page -->
    
    <meta name="revisit-after" content="30 days" /> <!--How often the page should be re-crawled -->
    
	<!-- Mobile -->
	
	<link rel="shortcut icon" type="image/x-icon" href="theme/favicon.ico">
    <link rel="apple-touch-icon" href="theme/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="theme/touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="theme/touch-icon-iphone4.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="theme/touch-icon-ipad-retina.png" />
	
    <!-- iPod/Phone 320 x 460 image -->
    <link rel="apple-touch-startup-image" href="theme/startup-iPod.jpg"/> 
	<!--iPad Portrait 768 x 1004 -->
    <link rel="apple-touch-startup-image" href="theme/startup-iPad-portrait.jpg" media="(device-width: 768px) and (orientation: portrait)" /> 
	<!--iPad LandScape 1024 x 748--> 
    <link rel="apple-touch-startup-image" href="theme/startup-iPad-landscape.jpg" media="(device-width: 768px) and (orientation: landscape)" /> 
    
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" /> <!--could be default-->
	
	<meta name="HandheldFriendly" content="True" />
	<meta id="Viewport" name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
	
	<!-- End Mobile -->
	
	<!-- CSS -->
	<link href="css/smoothness/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
    <link href="css/cboxStyles/1/colorbox.css" rel="stylesheet"/>
	
	<!-- End CSS -->
	
	<!-- Scripts -->
	<script src="js/jquery-1.8.3.js">              </script>
	<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="js/modernizr.js">                 </script>
	<script src="js/jquery.colorbox-min.js">       </script>
   
	<link href='http://fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/less" href="css/style.css" /> <!-- This auto includes the styleLib.less must be # 1 -->
   
    
	<script src="js/less-1.3.1.min.js" type="text/javascript"></script>
	<script src="js/blib.js" type="text/javascript"></script>  <!--Bren Scripts --> 
	
    <script type="text/javascript">
		var sessionId = "<?php echo $sessionID ?>";
			setViewPort(480); //viewport for mobile devices
			initNotificationControls('browser');
			initAccessibilityControls();
			//$('#expandy1').expandy("Read Me...");
		$(function(){	
			$('a.photoGalleryPhoto').colorbox();
		});
	</script>
	<!-- End Scripts -->
</head>

<body>


<div id="srollHeaderBar" class="siteSection">
		<div class="siteContent nonContentSiteSection">
		
		</div>
</div>

<div id="wrap">
	<div id="main">
		<div class="leatherWrap">
			<div class="siteSection nonContentSiteSection" id="header">
					<div class="siteContent">
						<div id="logo">
							<a onclick='notify("Hello, Thanks for visiting!","success","You Rock!");'>Bren's<br/>Site</a>
						</div>
						
						<div id="menu">
							<ul>
								<li>
									<a target="_blank" href="https://github.com/bren1818">Git Hub *new*</a>
								</li>
								<li>
									<a target="_blank" href="http://bren1818.blogspot.ca/">Blog</a>
								</li>
								<li>
									<a target="_blank" href="http://brendonirwin.dyndns.org">My Site (Hosted locally may be offline)</a>
								</li>
								<li>
									<a target="_blank" href="http://www.linkedin.com/pub/brendon-irwin/19/8b8/188">Linked In</a>
								</li>
							</ul>
						</div>
					</div>
			</div>
		</div>
	   
	   
        <div class="siteSection">
            <div class="siteContent">
				<h2>Your Gallery</h2>
				<?php
					include "imgResize.php";

					if( !is_dir('uploads/xhr/'.$sessionID) ){
						echo "<p>Sorry - Looks as though you haven't uploaded anything... Try Uploading something <a href='index.php'>here</a></p>";
					}else{
						echo "<div id='gallery'>";
						if ($handle = opendir('uploads/xhr/'.$sessionID)) {
							$url="http://".$_SERVER['HTTP_HOST']."/site/";
							$cwd = $url.'uploads/xhr/'.$sessionID."/";
							
							$files = "<ul>";
							$pics = "";
							
							while (false !== ($entry = readdir($handle))) {
								if ($entry != "." && $entry != "..") {
									$img = getcwd() ."\uploads\xhr\\".$sessionID."\\".$entry;
									$imgtypes = array("jpg", "jpeg", "gif", "png");
									$ret = explode(".", $entry);
									$extension = in_array( strtolower(end($ret)), $imgtypes );
									if(  $extension ){
									//echo "$entry\n";
									
									//echo $img;
									$resizeObj = new resize($img);  
									$resizeObj -> resizeImage(64, 64, 'crop');  
									
									$imgDATA = "data:image/jpg;base64,";
									ob_start();
										imagejpeg($resizeObj->getData(), null, 50);
										$imgDATA = $imgDATA. base64_encode( ob_get_contents() );
									ob_end_clean(); //clear buffer
									
									
										$pics = $pics.'<a rel="photoGalleryPhoto" class="photoGalleryPhoto" title="'.$entry.'" href="'.$cwd.$entry.'"><img download="thumb_'.$entry.'" src="'.$imgDATA.'" height="64" width="64" /></a>';
									
									}else{
										$files = $files.'<li><a rel="photoGalleryPhoto" class="file" title="'.$entry.'" href="'.$cwd.$entry.'">'.$entry.'</a></li>';
									}
								}
							}
							closedir($handle);
						}
						
						$files=$files.'</ul>';
						
						echo $pics;
						echo $files;
						
						echo "</div>";
					}
				?>
				<a href="index.php">Go Back and Upload some more.</a>
			</div>
		</div>
</div>
</div>
<div class="leatherWrap" id="footer">
   <div class="siteSection nonContentSiteSection" >
		<div class="siteContent">
			<p><span style="color: #fff;">&copy; Brendon Irwin</span></p>
		</div>
	</div>
</div>
</body>
</html>