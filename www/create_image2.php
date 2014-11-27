<?php
$width = 620;
$height = 620;
$im = imageCreate ( $width, $height );

$black = imageColorAllocate ( $im, 0, 0, 0 );
$blue = imageColorAllocate ( $im, 0, 0, 255 );
$white = imageColorAllocate ( $im, 255, 255, 255 );
$gray = imageColorAllocate ( $im, 200, 200, 200 );

$n = $in_n;
/*
 * $y = array ( 0, 5, 3, - 3, 0, 1 );
 */
$miny = $maxy = $y [0];
for($i = 1; $i < $n; $i ++) {
	if ($y [$i] > $maxy) {
		$maxy = $y [$i];
	}
	if ($y [$i] < $miny) {
		$miny = $y [$i];
	}
}

$minx = $in_t0;
$maxx = $in_tn;

$diffx = $maxx - $minx;
$diffy = $maxy - $miny;

if ($diffy > 0) {
	
	$h = $diffx / ($n - 1);
	
	imageFill ( $im, 0, 0, $gray );
	
	$_x = $minx;
	$_y = $y [0];
	
	$px = intval ( ($_x - $minx) * $width / $diffx ); // prevx
	$py = intval ( $height - ($_y - $miny) * $height / $diffy );
	
	$i = 1;
	while ( $i < $n ) {
		do {
			$_x = $minx + $i * $h;
			$_y = $y [$i];
			$nx = intval ( ($_x - $minx) * $width / $diffx ); // nextx
			$ny = intval ( $height - ($_y - $miny) * $height / $diffy );
			$i ++;
		} while ( $i < $n && $px == $nx && $py == $ny );
		imageLine ( $im, $px, $py, $nx, $ny, $black );
		
		$px = $nx;
		$py = $ny;
	}
	
	// малювання осей координат
	$ox = intval ( (0 - $minx) * $width / $diffx );
	$oy = intval ( $height - (0 - $miny) * $height / $diffy );
	
	imageLine ( $im, 0, $oy, $width, $oy, $blue );
	imageLine ( $im, $ox, 0, $ox, $height, $blue );
} else {
	imageString ( $im, 4, 10, 10, 'Error!', $white );
}

// Header ( "Content-Type:image/png" );
imagePNG ( $im );
imageDestroy ( $im );
?>