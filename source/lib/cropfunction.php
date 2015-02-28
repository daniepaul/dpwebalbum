<?php 
function smart_crop( $file, $size = 0,$newfile,$crop = false, $x, $y, $w, $h)
  {
    if ( $size <= 0 ) { return false; }
    	$info = getimagesize($file);
 	   	$image = '';
    $final_width = $size;
    $final_height = $size;
    list($width_old, $height_old) = $info;
     switch ( $info[2] )
		 {
		  case IMAGETYPE_GIF:
			$image = imagecreatefromgif($file);
		  break;
		  case IMAGETYPE_JPEG:
			$image = imagecreatefromjpeg($file);
		  break;
		  case IMAGETYPE_PNG:
			$image = imagecreatefrompng($file);
		  break;
		  default:
			return false;
		}
 
	$image_resized = imagecreatetruecolor( $final_width, $final_width );
 
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $trnprt_indx = imagecolortransparent($image);
 
      // If we have a specific transparent color
      if ($trnprt_indx >= 0) {
 
        // Get the original image's transparent color's RGB values
        $trnprt_color    = imagecolorsforindex($image, $trnprt_indx);
 
        // Allocate the same color in the new image resource
        $trnprt_indx    = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
 
        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $trnprt_indx);
 
        // Set the background color for new image to transparent
        imagecolortransparent($image_resized, $trnprt_indx);
 
 
      } 
      // Always make a transparent background color for PNGs that don't have one allocated already
      elseif ($info[2] == IMAGETYPE_PNG) {
 
        // Turn off transparency blending (temporarily)
        imagealphablending($image_resized, false);
 
        // Create a new transparent color for image
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
 
        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $color);
 
        // Restore transparency blending
        imagesavealpha($image_resized, true);
      }
    }
 
	if(!$crop)
	{
		if($width_old >= $height_old)
		{
			imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_width, $height_old, $height_old);
		}
		else
		{
			imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_width, $width_old, $width_old);
		}
	}
	else
	{
	 imagecopyresampled($image_resized, $image, 0, 0, $x, $y, $final_width, $final_height, $w, $h);
	}
	imagedestroy($image);
    switch ( $info[2] ) {
      case IMAGETYPE_GIF:
        imagegif($image_resized, $newfile);
      break;
      case IMAGETYPE_JPEG:
        imagejpeg($image_resized, $newfile);
      break;
      case IMAGETYPE_PNG:
        imagepng($image_resized, $newfile);
      break;
      default:
        return false;
    }
 	imagedestroy($image_resized);
	unlink($file);
    return true;
} 
?>