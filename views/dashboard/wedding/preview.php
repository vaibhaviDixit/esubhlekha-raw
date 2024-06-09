<?php

controller('Theme');
controller("Wedding");
controller("Gallery");

$wedding = new Wedding();
$weddingData = $wedding->getWedding($_REQUEST['id'], $_REQUEST['lang']);

// Instantiate the ThemeController class
$themeController = new ThemeController();
// Call the getThemes method
if(isset($_REQUEST['theme'])){
	$themes = $themeController->render($_REQUEST['theme'], $_REQUEST['type']);	
}
else if(isset($weddingData['template'])){
	$themes = $themeController->render($weddingData['template'], $_REQUEST['type']);	

}
