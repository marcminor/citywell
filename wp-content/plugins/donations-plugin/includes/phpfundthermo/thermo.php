<?
/*
     Fundraising Thermometer Generator v1.1
     Sairam Suresh sai1138@yahoo.com / www.entropyfarm.org
*/
error_reporting(7);
Header("Content-Type: image/jpeg"); 

$font = '../fonts/LiberationSans-Regular.ttf';

$unit = ($_GET['unit']) ? $_GET['unit'] : 36; // ascii 36 = $
$t_unit = ($unit == 'none') ? '' : $unit;
$t_max = ($_GET['max']) ? $_GET['max'] : 0;
$t_current = isset($_GET['current']) ? $_GET['current'] : 0;

$finalimagewidth = max(strlen($t_max),strlen($t_current))*25;
$finalimage = imagecreateTrueColor(60+$finalimagewidth,405);

$white = imagecolorallocate ($finalimage, 255, 255, 255);
$black = imagecolorallocate ($finalimage, 0, 0, 0);
$red = imagecolorallocate ($finalimage, 255, 0, 0);

imagefill($finalimage,0,0,$white);
ImageAlphaBlending($finalimage, true); 

$thermImage = imagecreatefromjpeg("therm.jpg");
$tix = ImageSX($thermImage);
$tiy = ImageSY($thermImage);
ImageCopy($finalimage,$thermImage,0,0,0,0,$tix,$tiy);

/*
  thermbar pic courtesy http://www.rosiehardman.com/
*/
$thermbarImage = ImageCreateFromjpeg('thermbar.jpg'); 
$barW = ImageSX($thermbarImage); 
$barH = ImageSY($thermbarImage); 


$xpos = 5;
$ypos = 327;
$ydelta = 15;
$fsize = 12;


// Set number of $ybars to use, calculated as a factor of current / max.
if ($t_current > $t_max) {
    $ybars = 25;
} elseif ($t_current > 0) {
    $ybars = $t_max ? round(20 * ($t_current / $t_max)) : 0;
}

// Draw each ybar (filled red bar) in successive shifts of $ydelta.
while ($ybars--) {
    ImageCopy($finalimage, $thermbarImage, $xpos, $ypos, 0, 0, $barW, $barH); 
    $ypos = $ypos - $ydelta;
}

if ($t_current == $t_max) {
    ImageCopy($finalimage, $thermbarImage, $xpos, $ypos, 0, 0, $barW, $barH); 
    $ypos -= $ydelta;
} 

// If there's a truetype font available, use it
if ($font && (file_exists($font))) {
    imagettftext ($finalimage, $fsize, 0, 60, 355, $black, $font,$t_unit."0");                 // Write the Zero
    imagettftext ($finalimage, $fsize, 0, 60, 10+(2*$fsize), $black, $font, $t_unit."$t_max");   // Write the max
    if ($t_current > $t_max) {
        imagettftext ($finalimage, $fsize+1, 0, 60, $fsize, $black, $font, $t_unit."$t_current!!"); // Current > Max
    } elseif($t_current != 0) {
        if ($t_current == $t_max) {
            imagettftext ($finalimage, $fsize, 0, 60, 10+(2*$fsize), $red, $font, $t_unit."$t_max!");  // Current = Max
        } else {
            if (round($t_current/$t_max) == 1) {
                $ypos += 2*$fsize;
            }
            imagettftext ($finalimage, $fsize, 0, 60, ($t_current > 0) ? ($ypos+$fsize) : ($ypos+(4*$fsize)), ($t_current > 0) ? $black : $red, $font, $t_unit."$t_current");  // Current < Max
        }
    }
}

if ($t_current > $t_max) {
    $burstImg = ImageCreateFromjpeg('burst.jpg');
    $burstW = ImageSX($burstImg);
    $burstH = ImageSY($burstImg);
    ImageCopy($finalimage, $burstImg, 0,0,0,0,$burstW, $burstH);
}

Imagejpeg($finalimage);
Imagedestroy($finalimage);
Imagedestroy($thermImage);
Imagedestroy($thermbarImage);

?>