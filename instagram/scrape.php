<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!file_exists("img/")) {
    mkdir("img", 0775);
}

$configFile = dirname(__FILE__) . '/../config.php';

if (file_exists($configFile))
{
    include $configFile;
}
else
{
    die("Please rename the config-sample.php file to config.php and add your Flickr API key and secret to it\n");
}

spl_autoload_register(function($className)
{
    $className = str_replace ('\\', DIRECTORY_SEPARATOR, $className);
    include (dirname(__FILE__) . '/src/' . $className . '.php');
});
use MetzWeb\Instagram\Instagram;

//for ($x = 1; $x <= 50; $x++) {

    //echo "Loading Page ".$x."\n\n";

    $instagram = new Instagram(array(
        'apiKey'      => $instagramApiKey,
        'apiSecret'   => $instagramApiSecret,
        'apiCallback' => 'http://www.mountvernon.org'
    ));

    $photos = $instagram->searchMedia($lat, $lon, (intval($radius)*1609.34));

    foreach ($photos->data as $photo) { 
        $filename = "img/".gmdate("Y-m-d@H:i:s", $photo->created_time)."::".$photo->user->username."-".$photo->id.".jpg";
        if (!file_exists($filename)) {
            echo "Saving ".$filename."\n";
            $img = file_get_contents($photo->images->standard_resolution->url);
            file_put_contents($filename,$img);
        }
    }

//}