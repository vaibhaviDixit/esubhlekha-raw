<?php

/**
 * Theme Controller
 *
 * GraphenePHP Theme Controller
 *
 * This class is responsible for theme rendering on eSubhalekha.com.
 * It provides functionalities to fetch available themes and render specific themes.
 *
 * @package GraphenePHP
 * @version 2.0.0
 */
class ThemeController
{
    // Create operation
    public function fetch()
    {
        $themesDir = 'themes';
        $themes = [];

        if (is_dir($themesDir)) {
            $files = array_diff(scandir($themesDir), array('.', '..'));
            foreach ($files as $file) {
                if (is_dir($themesDir . '/' . $file)) {
                    $themes[] = $file;
                }
            }
        }

        return $themes;
    }
    public function render($themeID, $type = "index")
    {   
        if(empty($type)) $type = "index";
        $themeDir = 'themes/' . $themeID;
        $typeFile = $themeDir . '/' . $type . ".php";

        if (!is_dir($themeDir)) {
            pageNotFound();
            throw new Exception("Theme not found: " . $themeID);
        }

        if (!is_file($typeFile)) {
            pageNotFound();
            throw new Exception("File not found: " . $type);
        }

        require $typeFile;

        return [$themeID, $type];
    }



}
