<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>

		<title>AI Projekt</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

		<link rel="stylesheet" type="text/css" href="/css/jquery.qtip.css"/>
		<link rel="stylesheet" type="text/css" href="/css/jquery-ui.min.css"/>
		<link rel="stylesheet" type="text/css" href="/css/supersized/supersized.css"/>
		<link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox.css"/>
		<link rel="stylesheet" type="text/css" href="/css/fancybox/helpers/jquery.fancybox-buttons.css"/>

		<link rel="stylesheet" type="text/css" href="/css/base.css"/>
		<link rel="stylesheet" type="text/css" media="screen and (max-width:969px)" href="/css/responsive/width-0-969.css"/>
		<link rel="stylesheet" type="text/css" media="screen and (max-width:767px)" href="/css/responsive/width-0-767.css"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:480px) and (max-width:969px)" href="/css/responsive/width-480-969.css"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:768px) and (max-width:969px)" href="/css/responsive/width-768-969.css"/>
		<link rel="stylesheet" type="text/css" media="screen and (min-width:480px) and (max-width:767px)" href="/css/responsive/width-480-767.css"/>
		<link rel="stylesheet" type="text/css" media="screen and (max-width:479px)" href="/css/responsive/width-0-479.css"/>

		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Voces"/>
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Dosis:400,300,200,500,600,700,800" />

		<script type="text/javascript" src="/js/jquery.min.js"></script>
	</head>

	<body>

    <div class="main main-body">

        <!-- Header -->
        <div class="header clear-fix">

            <div class="layout-50p clear-fix">

                <!-- Logo -->
                <div class="layout-50p-left clear-fix">
                    <a href="/" class="header-logo">Nostalgia</a>
                </div>
                <!-- /Logo -->

                <div class="layout-50p-right">

                    <?php
                    if(isset($_SESSION['login_data']['logged_in']) && $_SESSION['login_data']['logged_in'] == 1){
                        echo '<div class="header-phone">';
                        echo '<a href="/logout">LOGOUT</a>';
                        echo '</div>';
                    }
                    ?>

                    <div class="header-phone">
                        Call Support 1-800-123-124
                    </div>

                </div>

            </div>

        </div>
        <!-- /Header -->
