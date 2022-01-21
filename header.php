<?php 
	/* Copyright 2018 Atos SE and Worldline
	 * Licensed under MIT (https://github.com/atosorigin/DevOpsMaturityAssessment/blob/master/LICENSE) */

	require 'survey.php'; 
	
	$survey = new Survey;
	
	// Create an array to represent the navbar buttons
	$navBar = array (
		'Questionaire' => array ('Url' => 'section-' . SectionNameToURLName($survey->sections[0]['SectionName']), 'Type' => 'Standard'),
		'Sections' => array ('Type' => 'Dropdown' ),
				// Sub-menus for each page are added here (see below)
		'Results' => array ('Url' => 'results', 'Type' => 'Standard' ),
		'Detailed Reports' => array ('Type' => 'Dropdown', 'Items' => array (
				'Download CSV' => array('Url' => 'devops-maturity-csv.php', 'Type' => 'Standard'),
				'Divider1' => array('Type' =>'Divider') ) ),
				// Sub-menus for detailed reports are added here, see below
		'Resources' => array ('Url' => 'resources', 'Type' => 'Standard' ),
		'About' => array ('Url' => 'about', 'Type' => 'Standard' ) );
	
	// Add the sub-menus for each page of the survey, and also for the detailed reports
	foreach ($survey->sections as $section)
	{
		$navBar['Sections']['Items'][$section['SectionName']]['Url'] = 'section-' . SectionNameToURLName($section['SectionName']);
		$navBar['Sections']['Items'][$section['SectionName']]['Type'] = 'Standard';
		if ( $section['HasSubCategories'] )
		{
			$navBar['Detailed Reports']['Items'][$section['SectionName']]['Url'] = 'results-' . SectionNameToURLName($section['SectionName']);
			$navBar['Detailed Reports']['Items'][$section['SectionName']]['Type'] = 'Standard';
		}
	}
	
	function GetBaseURL()
	{
		// Routine based on https://wp-mix.com/php-absolute-path-document-root-base-url/
		
		$doc_root = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['SCRIPT_FILENAME']);
		//$doc_root = str_replace($doc_root, "\\", "\\");
		
		// base directory
		$base_dir = __DIR__;
		$base_dir = str_replace("\\", "/", $base_dir);
		
		// server protocol
		$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

		// domain name
		$domain = $_SERVER['SERVER_NAME'];

		// base url
		$base_url = str_replace($doc_root, '', $base_dir);
		
		// server port
		$port = $_SERVER['SERVER_PORT'];
		$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

		// put em all together to get the complete base URL
		return $protocol . "://" . $domain . $disp_port . $base_url;

	}
	
	function SectionNameToURLName($sectionName) {
		return strtolower(str_replace(',', '', str_replace(' ', '-', $sectionName)));
	}
	
	function RenderNavBarButtons($navBar)
	{
		foreach ($navBar as $index=>$navBarButton)
		{
			switch ( $navBarButton['Type'] ) {
				case 'Standard':
					RenderStandardNavBarButton($index, $navBarButton['Url']);
					break;
				case 'Dropdown':
					RenderDropdownNavBarButton($index, $navBarButton);
					break;
			}
		}
	}
	
	function OnClickHandler($url)
	{
		global $isForm;
		if ( $isForm )
		{
			// If the page contains a form then we need to set the form action and submit
			return "$('form').attr('action', '$url'); $('form').submit();";
		}
		else
		{
			// If the page is not a form then just navigate to the right URL
			return "window.location = '$url';";
		}
	}
	
	function RenderStandardNavBarButton($buttonText, $url)
	{
		// Check if this is the button for the current page, and if so style it accordingly
		global $activePage;
		$active = '';
		if ($activePage == $buttonText)
		{
			$active = ' active';
		}
		?>
		<li>
			<a href="#" class="nav-link<?=$active?>" onclick="<?=OnClickHandler($url)?>"><?=$buttonText?></a>
		</li>
		<?php
	}
	
	function RenderDropdownNavBarButton($buttonText, $navBarButton)
	{
		// Check if this is the button for the current page, and if so style it accordingly
		global $activePage;
		$active = '';
		if ($activePage == $buttonText)
		{
			$active = ' active';
		}
		?>
		<li class="navbar-item dropdown">
			<a href="#" class="nav-link dropdown-toggle<?=$active?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?=$buttonText?>
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<?php foreach ($navBarButton['Items'] as $index=>$dropdownItem) { 
					switch ( $dropdownItem['Type'] ) {
						case 'Standard': ?>
							<a class="dropdown-item" href="#" onclick="<?=OnClickHandler($dropdownItem['Url'])?>"><?=$index?></a>
							<?php break;
						case 'Divider': ?>
							<div class="dropdown-divider"></div>
							<?php break;
					}
				}?>
			</div>
		</li>
		<?php
	}
	
?>

<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Open Graph info -->
		<meta property="og:title" content="DevOps Maturity Assessment" />
		<meta property="og:description" content="This online DevOps Maturity Assessment questionnaire will help you understand your current strengths and weaknesses and then recommend resources that can support you in taking the next steps on your DevOps journey." />
		<meta property="og:site_name" content="DevOps Maturity Assessment" />
		<meta property="og:image" content="<?=GetBaseURL()?>/og-image.jpg" />
		<meta property="og:image:width" content="1680" />
		<meta property="og:image:height" content="870" />
		
		<!-- Favicon stuff - check out https://realfavicongenerator.net/ -->
		<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<link rel="manifest" href="site.webmanifest">
		<link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#2d89ef">
		<meta name="theme-color" content="#ffffff">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="fontawesome/css/all.css" rel="stylesheet">

		<title>DevOps Maturity Assessment</title>
		<script src="./js/chart.bundle.min.js"></script>
		<script src="js/jquery-3.3.1.min.js"></script>		
		<style>
			.sectionPadding{
				padding: 60px 0;
			}

.bannerText{
  display:flex;
  align-items: center;
  height: 100vh;
  background: linear-gradient(60deg,rgb(0 0 0 / 65%) 0%,rgb(0 0 0 / 55%) 100%),url(banner.jpg);
}

.bannerHeader {
  padding: 150px 0 50px;
  position: relative;
  background-position: top left !important;
  background: url(og-image.jpg);
}

a.dropdown-item:active{
  background-color: #2a55a3 !important;
}

.bg-questionHolder{
  background-color: #2a55a3 !important;
  border-radius: 0px 0px 4px 4px;
}

.questionHoldertxt{
  color: black !important;
  margin-left: 10px;
  text-align: center;
}

button.submitBtnStyle {
  cursor: pointer;
  padding: 8px 18px;
  font-size: 15px;
  background: #2a55a3;
  color: white;
  border-radius: 4px;
  border: 0px;
  margin: 0px 10px;
  transition: 0.4s all;
  outline: none !important;
  border: 1px solid #2a55a3;
}

button.submitBtnStyle:hover{
  border: 1px solid #2a55a3;
  color:#2a55a3;
  background-color: white;
  transition: 0.4s all;
}

.navMenuStyle{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  background: #ffffffe0;
  padding: 0px;
  transition: margin-top 0.4s ease-in-out;
  border-bottom: 1px solid #00000029;
  z-index: 99;
}

.bannerHeader h2 {
  font-size: 32px;
  color: white;
  font-weight: 500;
}

.navFixedMenu{
  background-color: white;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
  width: 100%;
  animation: smoothScroll 0.8s forwards;
}

.headerText h1{
  font-size: 33px;
  font-weight: 600;
  line-height: 1.6;
  color: white;
}

.headerText p{
  font-size: 19px;
  line-height: 1.6;
  color: #f5f5f5;
  margin-bottom: 1.8rem;
}

.navMenuStyle .dropdown-menu{
  padding-top: 4px;
  border-top: 2px solid #2a55a3;
}

.navMenuStyle a{
  color: black !important;
  padding: 4px 15px;
}

a{
  text-decoration: none !important;
}
/* services css */
.serviceDetails {
  padding: 20px;
  border-radius: 5px;
  border: 1px solid rgb(51 51 51 / 21%);
}

.serviceDetails:hover{
  color: #2a55a3;
  transition: all 0.2s;  
  box-shadow: 1px 2px 8px -2px rgb(0 0 0 / 30%);
}

span.iconStyle {
  font-size: 1.5rem;
  color: #2a55a3;
}

.serviceDetails h3{
  font-size: 24px;
  margin-bottom: 14px;
  margin-top: 20px;
}

h2.sectionHeading{
  text-align: center;
  font-size: 28px;
}

.serviceDetails p{
  color: #747474;
  font-size: 15px;
  margin: 0px;
  line-height: 1.6;
}
/* footer */
.footerText{
  padding: 13px 10px;
  background: #2a55a3;
}

.footerText p{
  font-size: 15px;
  color: white;
  margin: 0px;
  text-align: center;
}

a.btnStyle1 {
  cursor: pointer;
  padding: 10px;
  font-size: 16px;
  background: #2a55a3;
  color: white;
  border-radius: 4px;
}

a.btnStyle2 {
  cursor: pointer;
  padding: 9px;
  font-size: 16px;
  border:1px solid #ffffff;
  color: #ffffff;
  border-radius: 4px;
}

a.btnStyle1:hover{
  background-color: white;
  color: #2a55a3;
  transition: 0.3s all;
}

a.btnStyle2:hover{
  background-color: #2a55a3;
  color: white;
  transition: 0.3s all;
  border-color: #2a55a3;
}

.navbar-light .navbar-toggler-icon {
    background-image: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 0, 0, 0.5)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e);
}
		
			@media (max-width: 520px) { 
				.navMenuStyle a{
					font-size:16px !important;
				}
				span.iconStyle{
					font-size: 16px !important;
				}
				.serviceDetails {
    				padding: 15px;
				}
				.headerText h1 {
    				font-size: 22px;
				}
				.headerText p {
    				font-size: 15px;
				}
				a.btnStyle1 {
					padding: 8px;
					font-size: 14px;
				}
				a.btnStyle2 {
					padding: 8px;
					font-size: 14px;
				}
				.serviceDetails h3 {
    				font-size: 18px;
				}
				h2.sectionHeading{
					font-size: 20px;
				}
				.bannerHeader h2 {
    				font-size: 22px;
				}
				.bannerHeader{
					background-size: cover !important;
				}
				h5.bg-questionHolder{
					font-size: 17px !important;
					padding: 10px;
				}
				.smBorderHide{
					border: 0px !important;
				}
				.card-footer.bg-questionHolder {
					padding: 10px;
					font-size: 12px;
				}
				#resultDetails p{
					font-size: 15px !important;
				}
				#resultDetails a.card-link{
					font-size: 15px !important;
				}
				#resultDetails .fa, .fas, .far, .fal, .fab{
					font-size: 13px !important;
				}
			}

			@media (max-width: 768px){
				.dropdown-menu.show {
					box-shadow: none !important;
    				border: 1px solid #00000070;
    				padding: 0px !important;
				}
				.navMenuStyle .dropdown-menu a {
					padding: 6px 4px;
					border-top: 1px dashed #00000047;
				}
				.dropdown-divider{
					display: none !important;
				}
				.navMenuStyle .navbar-dark .navbar-toggler-icon{
				filter: invert(1);
				background-size: 22px;
			}
			button.navbar-toggler {
    			border: 1px solid #00000061 !important;
    			padding: 1px 3px;
				outline: none !important;
			}
			.navCollpase {
				position: absolute;
				top: 100%;
				background: white;
				width: 100%;
				right: 0px;
				border: 1px solid #0000001f;
				padding: 0px;
			}
			.navCollpase ul li {
				padding: 4px 8px;
				
			}
			.navCollpase ul li+li{
				border-top: 1px dashed #0000002e;
			}
			}
			
		</style>
		
	</head>
	
	<body id="bigwrapper">
<header class="navMenuStyle">
	<nav class="navbar navbar-dark navbar-expand-lg">
		<a href="about" class="navbar-brand">DevOps Maturity Assessment</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse navCollpase" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<?php RenderNavBarButtons($navBar); ?>
			</ul>
		</div>
	</nav>	
</header>	
