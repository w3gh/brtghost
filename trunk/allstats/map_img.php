<?php
function LoadJpeg($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a black image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}
header('Content-Type: image/jpeg');
$towers = Array();
$towers["01"] = Array(1, 34, 105, 0);
$towers["02"] = Array(1, 34, 155, 0);
$towers["03"] = Array(1, 34, 200, 0);
$towers["11"] = Array(1, 115, 160, 0);
$towers["12"] = Array(1, 80, 190, 0);
$towers["13"] = Array(1, 60, 215, 0);
$towers["141"] = Array(1, 41, 226, 0);
$towers["142"] = Array(1, 48, 235, 0);
$towers["21"] = Array(1, 230, 245, 0);
$towers["22"] = Array(1, 130, 245, 0);
$towers["23"] = Array(1, 80, 245, 0);
$towers["31"] = Array(1, 60, 36, 1);
$towers["32"] = Array(1, 140, 36, 1);
$towers["33"] = Array(1, 190, 36, 1);
$towers["41"] = Array(1, 158, 133, 1);
$towers["42"] = Array(1, 185, 100, 1);
$towers["43"] = Array(1, 210, 75, 1);
$towers["441"] = Array(1, 223, 53, 1);
$towers["442"] = Array(1, 232, 62, 1);
$towers["51"] = Array(1, 248, 165, 1);
$towers["52"] = Array(1, 248, 130, 1);
$towers["53"] = Array(1, 248, 90, 1);

if(isset($_GET["kt"]))
{
	$kt = $_GET["kt"];

	$im = LoadJpeg("map.jpg");
	
	$scourge_color = imagecolorallocate($im, 255, 10, 10);
	$sentinel_color = imagecolorallocate($im, 10, 255, 10);
	$dead_color = imagecolorallocate($im, 80, 80, 80);
	
	for($i = 0; $i < strlen($kt); $i+=2)
	{
		$key = substr($kt, $i, 2);
		if($kt[$i+1] == "4")
		{
			if($towers[$key."1"][0])
				$towers[$key."1"][0] = 0;
			else
				$towers[$key."2"][0] = 0;
		}else{
			$towers[$key][0] = 0;
		}
	}

	foreach($towers as $t=>$v)
	{
		imagefilledellipse($im, $v[1], $v[2], 10, 10, ($v[0] ? ($v[3] ? $scourge_color : $sentinel_color) : $dead_color));
	}
}else{
	$im = LoadJpeg("map.jpg");
}

imagejpeg($im);
imagedestroy($im);
?>