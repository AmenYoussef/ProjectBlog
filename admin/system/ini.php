<?php

// Incloud Config File

include 'config.php';

// Routes

$NameThemes = 'default';    // Name Active Themes

$fileCss    = 'incloud/themes/' . $NameThemes . '/Css/';     // a path File Css

$filejs     = 'incloud/themes/' . $NameThemes . '/js/';      // a path File Js

$fileimg    = 'incloud/themes/' . $NameThemes . '/img/';     // a path File Img

$filefont   = 'incloud/themes/' . $NameThemes . '/fonts/';    // a path File Font

$folderFunc = 'incloud/function/';   // A path Folider Function

$folderLang = 'incloud/languages/';   // A path Folider languages

$foldertemp = 'incloud/templates/';   // A path Folider templates

// Incloud Importants File

include $folderFunc . 'mine.php';

include $folderLang . 'eng.php';

include $foldertemp . 'header.php';

// Include Navbar On All Pages Expect The One With $noNavbar Vairable
	if(!isset($noNavbar)) { include $foldertemp . 'navbar.php'; }