<?php
/*
make random image number check
20050524 by ascent WebAQ.com
*/

$rands = rand(1000,9999);

session_start();
$_SESSION['random_image_number_check'] = $rands;

$bg = './random_image_bg.jpg';
$numimgp = './random_image_number_%d.gif';

$numimg1 = sprintf($numimgp,substr($rands,0,1));
$numimg2 = sprintf($numimgp,substr($rands,1,1));
$numimg3 = sprintf($numimgp,substr($rands,2,1));
$numimg4 = sprintf($numimgp,substr($rands,3,1));
$ys1 = rand(-4,4);
$ys2 = rand(-4,4);
$ys3 = rand(-4,4);
$ys4 = rand(-4,4);

$bgImg = imageCreateFromJPEG($bg);
$nmImg1 = imageCreateFromGIF($numimg1);
$nmImg2 = imageCreateFromGIF($numimg2);
$nmImg3 = imageCreateFromGIF($numimg3);
$nmImg4 = imageCreateFromGIF($numimg4);
imageCopyMerge($bgImg, $nmImg1, 10, $ys1, 0, 0, 20, 30, 50);
imageCopyMerge($bgImg, $nmImg2, 30, $ys2, 0, 0, 20, 30, 50);
imageCopyMerge($bgImg, $nmImg3, 50, $ys3, 0, 0, 20, 30, 50);
imageCopyMerge($bgImg, $nmImg4, 70, $ys4, 0, 0, 20, 30, 50);
header("Content-type: image/jpg");
ImageJPEG($bgImg,"",100);
imagedestroy($bgImg);
imagedestroy($nmImg1);
imagedestroy($nmImg2);
imagedestroy($nmImg3);
imagedestroy($nmImg4);
?>