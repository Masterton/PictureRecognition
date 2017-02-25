<?php
/* $path = './upload/aa/01.jpg';
//return getimagesize($path);
$percent = 0.1;

header('Content-type: image/jpeg');
list($width, $height) = getimagesize($path);
$newwidth = 8;
$newheight = 8;

$thumb = imagecreatetruecolor($newwidth, $newheight);

$source = imagecreatefromjpeg($path);

imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

//imagejpeg($thumb, './upload/01_hash.jpg', 100);
imagejpeg($thumb); */

//header('content-type:image/jpeg');
$url_img = './upload/01_hash.jpg';
$img = imagecreatefromjpeg($url_img);//由文件或 URL 创建一个新jpg图象。
$x = imagesx($img);
$y = imagesy($img);
$gray_img = imagecreatetruecolor($x, $y);//新建一个真彩色图像
imagecolorallocate($gray_img, 0, 0, 0);//取消图片颜色的分配
$gray64 = array();
for ($i = 0; $i < $x; $i++) {
	for ($j = 0; $j < $y; $j++) {
		$rgb = imagecolorat($img, $i, $j);//取得某像素的颜色索引值
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		//for gray mode $r = $g = $b
		//$color = max(array($r, $g, $b));
		$color = (19595 * $r + 38469 * $g + 7472 * $b) >> 16;
		array_push($gray64, $color);
		
		print_r($r);
		print_r($g);
		print_r($b);
		print_r('<br />');
		//$gray_color = imagecolorexact($gray_img, $color, $color, $color);//取得指定颜色的索引值
		//imagesetpixel($gray_img, $i, $j, $gray_color);//画一个单一像素
	}
	
}
//imagejpeg($gray_img);
print_r('<pre>');
print_r($gray64);
print_r('<br />');
$total = 0;
for($m = 0; $m < count($gray64); $m++){
	$total += $gray64[$m];
}

$aa = $total/64;

print_r($aa);
print_r('<br />');

$Binary = array();
$str = "";
for($n = 0; $n < count($gray64); $n++){
	if($gray64[$n] < $aa){
		$bb = 0;
	}else{
		$bb = 1;
	}
	array_push($Binary, $bb);
	$str .= $bb;
}

print_r($Binary);
print_r('<br />');
print_r($str);
print_r('<br />');

$strs = "";
for($k = 0; $k < strlen($str); $k += 4){
	$hex = dechex($str[$k] * 8 + $str[$k+1] * 4 + $str[$k+2] * 2 + $str[$k+3]);
	$strs .= $hex;
}
print_r($strs);
print_r('<br />');