<?php
//set faction ID and faction name here.
$factionid='ADD_FACTION_ID_HERE';
$factioname='ADD_FACTION_NAME_HERE';
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
//$file = 'requestslog.txt';
//$fdata = file_get_contents ( $file );
//$fdata = intval($fdata) + 1;
//file_put_contents($file, $fdata);

// Firstly open the image
$selectedimage = 'includes/'.$factionid.'-'.$selectedimage.'.png';
$img = imagecreatefrompng($selectedimage);
// Set text properties
$fontsize = 10;
$rankfontsize = 30;
$angle = 0;
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
$font = "includes/UBUNTU-MEDIUM.TTF";
$rankfont = "includes/PNR.ttf";
//Add the text
$txt = $status->name.'['.$status->player_id.']  |  Level:'.$status->level.'  |  Age:'.$status->age.'  |  '.$status->rank.'  |  '.$status->status->state ;
$txt2 = $status->faction->position.' of '.$faction_name ;
//Calculate text size to center it
$image_width = imagesx($img);
$text_box = imagettfbbox($fontsize,$angle,$font,$txt);
$text2_box = imagettfbbox($rankfontsize,$angle,$rankfont,$txt2);
$text_width = $text_box[2]-$text_box[0];
$text2_width = $text2_box[2] - $text2_box[0];
$x = ($image_width/2) - ($text_width/2);
$x2 = ($image_width/2) - ($text2_width/2);
//Write text to image
imagettftext($img, $fontsize, $angle, $x, 15, $white, $font, $txt);
imagettftext($img, $rankfontsize, $angle, $x2, 75, $white, $rankfont, $txt2);
//Image Output
header('Content-type: image/png');
imagepng($img);
imagedestroy($img);
?>
