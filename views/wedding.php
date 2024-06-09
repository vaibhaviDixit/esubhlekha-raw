<?php

controller('Theme');

// Instantiate the ThemeController class
$themeController = new ThemeController();

// Call the getThemes method
$themes = $themeController->render('sample_theme', $_REQUEST['type']);
