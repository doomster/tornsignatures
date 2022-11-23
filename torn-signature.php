<?php

//set faction ID and faction name here.
$factionid='ADD_FACTION_ID_HERE';
$factioname='ADD_FACTION_NAME_HERE';
//caching time of signature image so that you dont spam the server with requests. 
$cachetime = 10;
//The path and filename that we give to the image when we cache it.
$cachefile = 'cache/' . basename($_SERVER['PHP_SELF']) .'.'.$_GET['id'].'.png';
//$cachefile = 'cache/sign_cache_'.$_GET['id'].'.jpg';
//Check to see if this image already exists.
//if(is_readable($filepath)){
if (file_exists($cachefile) && time() - $cachetime <= filemtime($cachefile)) {
    //The file exists, so lets display it.
    header("Content-type: image/png");
    readfile($cachefile);
    exit;
}
//load random api key from list
require 'includes/'.$factionid.'-apikeys.php';
$randmax = count($apikeys);
$rand = rand(0,$randmax);
//request data from server
$statusrequest = file_get_contents('http://api.torn.com/user/'.$_GET['id'].'?selections=&key='.$apikeys[$rand]);
//check if there is an image request, or default to 1st one
if(isset($_GET['img'])) { $selectedimage = $_GET['img']; } else { $selectedimage = '1' ; }
$status = json_decode($statusrequest);
//setup variables
$faction_check = $status->faction->faction_id;
$faction_rank = $status->faction->position;
$faction_name = $status->faction->faction_name;
//check if he is a member of the faction. Allways change the name here according to the faction.
if ($faction_check != $factionid) { die('Not a member of '.$factioname); }
// REQUESTS COUNTER (uncomment next four lines to get a counter for the requests, for usage purposes)
//$file = 'requestslog.txt_status';
//$fdata = file_get_contents ( $file );
//$fdata = intval($fdata) + 1;
//file_put_contents($file, $fdata);

// Firstly open the image
$img_background = imagecreatefrompng('includes/'.$factionid.'-'.$selectedimage.'.png');
// Set text properties
$font_status_size = 10;
$font_rank_size = 30;
$angle = 0;
$white = imagecolorallocate($img_background, 255, 255, 255);
$black = imagecolorallocate($img_background, 0, 0, 0);
$font_status = "includes/UBUNTU-MEDIUM.TTF";
$font_rank = "includes/PNR.ttf";
//Add the text
$txt_status = $status->name.'['.$status->player_id.']  |  Level:'.$status->level.'  |  Age:'.$status->age.'  |  '.$status->rank.'  |  '.$status->status->state;
$txt_rank = $status->faction->position.' of '.$factionname ;
//Calculate text size to center it
$image_width = imagesx($img_background);
$txt_box_status = imagettfbbox($font_status_size,$angle,$font_status,$txt_status);
$txt_box_rank = imagettfbbox($font_rank_size,$angle,$font_rank,$txt_rank);
$text_width = $txt_box_status[2]-$txt_box_status[0];
$text2_width = $txt_box_rank[2] - $txt_box_rank[0];
$x_status = ($image_width/2) - ($text_width/2);
$x_rank = ($image_width/2) - ($text2_width/2);
//Write text to image
imagettftext($img_background, $font_status_size, $angle, $x_status, 15, $white, $font_status, $txt_status);
imagettftext($img_background, $font_rank_size, $angle, $x_rank, 75, $white, $font_rank, $txt_rank);
//Save the image to the cached filepath location.
imagepng($img, $cachefile);
//Image Output
header('Content-type: image/png');
imagepng($img_background);
imagedestroy($img_background);
?>

