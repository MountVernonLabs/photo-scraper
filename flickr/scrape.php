<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

mkdir("img", 0775);

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
use \DPZ\Flickr;

for ($x = 1; $x <= 50; $x++) {

    echo "Loading Page ".$x."\n\n";

    $flickr = new Flickr($flickrApiKey, $flickrApiSecret);
    $parameters =  array(
        'lat'           => $lat,
        'lon'           => $lon,
        'accuracy'      => 16,
        'per_page'      => 100,
        'extras'        => 'path_alias,license,url_o,date_taken',
        'radius'        => $radius,
        'safe_search'   => '1',
        'content_type'  => '1',
        'page'          => $x,
    );
    $response = $flickr->call('flickr.photos.search', $parameters);
    $photos = $response['photos'];

    //print_r($photos);

    foreach ($photos['photo'] as $photo) { 
        if (isset($photo["url_o"])){
            $filename = 'img/'.str_replace(" ", "@", $photo['datetaken']).'::'.$photo['pathalias'].'-'.$photo['id'].'-'.$photo['license'].'.jpg';
            if (!file_exists($filename)) {
                echo "Saving ".$filename."\n";
                $img = file_get_contents($photo["url_o"]);
                file_put_contents($filename,$img);
            }
        }
    }
}