<?php

//path where to store images
$path_thumbs = "../fotos";
$path_big = "../fotos";

//the new width of the resized image.
$img_thumb_width = 320; // in pixcel

$extlimit = "yes"; //Do you want to limit the extensions of files uploaded (yes/no)
//allowed Extensions
$limitedext = array(".gif",".jpg",".png",".jpeg",".bmp");


//check if folders are Writable or not
//please CHOMD them 777
if (!is_writeable($path_thumbs)){
   die ("Error: The directory <b>($path_thumbs)</b> is NOT writable");
}
if (!is_writeable($path_big)){
    die ("Error: The directory <b>($path_big)</b> is NOT writable");
}

?>
