<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
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
use \DPZ\Flickr;


$flickr = new Flickr($flickrApiKey, $flickrApiSecret);
$parameters =  array(
    'lat'           => $lat,
    'lon'           => $lon,
    'accuracy'      => 16,
    'per_page'      => 100,
    'extras'        => 'url_sq,path_alias,license,url_o',
    'radius'        => $radius,
    //'safe_search'   => '1',
    //'content_type'  => '1',
    'page'          => $page,
);
$response = $flickr->call('flickr.photos.search', $parameters);
$photos = $response['photos'];

//print_r($photos);

?>
<!DOCTYPE html>
<html>
    <head>
        <!--<link rel="stylesheet" href="example.css" />-->
    </head>
    <body>
        <ul id="photos">
            <?php foreach ($photos['photo'] as $photo) { ?>
                <li>
                    <a href="<?php echo sprintf("http://flickr.com/photos/%s/%s/", $photo['pathalias'], $photo['id']) ?>">
                        <img src="<?php echo $photo['url_sq'] ?>" />
                    </a>
                    <?= $photo["url_o"]?> | <?= $photo["license"]?>
                </li>
            <?php } ?>
        </ul>
    </body>
</html>