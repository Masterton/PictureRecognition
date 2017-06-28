<?php
/**
 * 生成图片的识别指纹（fingerprint）字符串
 * 感知哈希算法（Perceptual hash algorithm）
 * @author louds
 * @time 2017-2-8 15:40:37
 * @version 0.0.1
 * 
 */

namespace PictureRecognition;

/**
 * class PHAHash
 */
class PHAHash
{
	
	/**
	 * 获取图片的指纹
	 * @param $path 图片的路径
	 * @param $hash 图片的指纹
	 *
	 */
	public function Obtain($path)
	{

		//生成缩小的图片和返回路径
		$reduce = $this->Reduce($path);

		//获取图片64个像素的64个灰度值
		$gray64 = $this->SimplifiedCole($reduce);

		//获取图片64给我灰度值的平均值
		$average = $this->GrayAverage($gray64);

		//获取比较像素的灰度后生成的64位二进制数
		$binary = $this->Binary($average, $gray64);

		//把64位二进制数转换为16位的十六进制（hash值）
		$hash = $this->Fingerprint($binary);

		//输出图片的指纹（hash值）
		//return $hash;ff07030183e1e3ff
		$similarity = $this->Compare($hash, "6437d68e0ec6d723");

		return $similarity;
	}

	/**
	 * 一、把图片缩小到（8*8=64像素）的图片。去除图片的细节，只保留结构、明暗等基本信息，摒弃不同尺寸、比例带来的图片差异。
	 * @param $path 上传图片的路径
	 * @param $height 图片的原始高度
	 * @param $width 图片的原始宽度
	 * @param $size 缩小后图片的尺寸
	 * @return $thumb 生成的图片缩小后的图片的路径
	 * 
	 */
	public function Reduce($path)
	{
		//header('Content-type: image/jpeg');
		//list() 函数用数组中的元素为一组变量赋值。
		list($width, $height) = getimagesize($path);
		
		$size = 8;//图片的新尺寸
		
		//新建一个真彩色图像
		$thumb = imagecreatetruecolor($size, $size);
		
		//由文件或URL创建一个新jpeg图像
		$source = imagecreatefromjpeg($path);
		
		//重采样拷贝部分图像并调整大小
		imagecopyresampled($thumb, $source, 0, 0, 0, 0, $size, $size, $width, $height);

		$name = explode("/", $path);

		$name = explode(".", end($name));

		$name = "./upload/" . reset($name) . "_hash.jpg";

		//输出图像到浏览器或文件
		imagejpeg($thumb, $name, 100, 100);
		
		//输出缩小后的图像文件
		return $name;
	}
	
	/**
	 * 二、简化色彩。将缩小后的图片，转为64级灰度。也就是说，所有像素点总共只有64种颜色。
	 * @param $path 图片路径
	 * @return $gray64 64种颜色集合（64个像素的灰度）
	 * 
	 */
	public function SimplifiedCole($path)
	{

		//有文件或 URL 创建一个新JPG图像
		$img = imagecreatefromjpeg($path);

		//取得图像宽度和高度(像素)
		$width = imagesx($img);
		$heigh = imagesy($img);

		$gray64 = [];

		//获取图片每个像素的颜色索引值装换为rgb颜色，rgb颜色转换为64级灰度
		for ($i = 0; $i < $width; $i++) { 
			for ($j = 0; $j < $heigh; $j++) { 

				//取得指定像素的颜色索引值
				$rgb = imagecolorat($img, $i, $j);

				//取得各自的rgb值
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;

				//将图像每个像素的颜色转换为64级灰度
				$color = (19595 * $r + 38469 * $g + 7472 * $b) >> 16;

				array_push($gray64, $color);
			}
		}
		unlink($path);
		return $gray64;
	}

	/**
	 * 三、计算平均值。计算所有64个像素的灰度平均值。
	 * @param $gray64 64个像素的64个颜色
	 * @return $average 64个像素的灰度平均值
	 *
	 */
	public function GrayAverage($gray64)
	{

		$total = 0;

		//循环 64个灰度值
		for ($m = 0; $m < count($gray64); $m++) {

			//求 64个灰度值的总和
			$total += $gray64[$m];
		}

		//灰度平均值
		$average = $total / 64;
		return $average;
	}

	/**
 	 * 四、比较像素的灰度。将每个像素的灰度，与平均值进行比较。大于或等于平均值，记为1；小于平均值，记为0。(获得一个64位的二进制数)
 	 * @param $average 64个像素的灰度平均值
 	 * @param $gray64 64个像素的64个灰度值
 	 * @return $binary 64位的二进制数
 	 *
	 */
	public function Binary($average, $gray64)
	{

		//定义存入64位二进制数的字符串
		$binary = "";

		//比较64个灰度值与平均灰度值
		for ($n = 0; $n < count($gray64); $n++) { 

			if ($gray64[$n] < $average) {

				//如果灰度值小于平均灰度值，当前为就填入0
				$binary .= 0;
			}else{

				//如果灰度值大于等于平均灰度值，当前为就填入1
				$binary .= 1;
			}
		}
		return $binary;
	}

	/**
	 * 五、计算哈希值（生成图片的指纹）。把 64位的二进制数转为 16位的十六进制数
	 * @param $binary 64位的二进制数
	 * @return $hex 16位的十六进制数（就是这张图片的指纹）
	 *
	 */
	public function Fingerprint($binary)
	{

		$hex = "";

		//循环64位二进制数，按4位一起取出转化为十六进制
		for ($k = 0; $k < strlen($binary); $k += 4) { 

			//转化为十六进制数
			$number = dechex($binary[$k] * 8 + $binary[$k+1] * 4 + $binary[$k+2] * 2 + $binary[$k+3]);
			//把十六进制数连接成 16位的十六进制数
			

			$hex .= $number;
		}
		return $hex;
	}

	/**
	 * 验证两张图片是否相似
	 * @param $model 上传查找的图片 指纹
	 * @param $resource 对比的图片 指纹
	 * @return boolean
	 *
	 */
	public function Compare($model, $resource)
	{
		$m_binary = "";
		$r_binary = "";
		$aa = array();

		//把两张图片的指纹都转换为 64位的二进制数
		for ($m = 0; $m < strlen($model); $m++) { 

			//按位数一位一位的转换为二进制数
			$bin = base_convert($model[$m], 16, 2);
			$bins = base_convert($resource[$m], 16, 2);

			$fill = "";
			$fills = "";

			//判断转换成的二进制数是不是 4位
			if (strlen($bin) != 4) {
				//不足 4位，在前面补0
				for ($d = 0; $d < 4-strlen($bin); $d++) { 
					$fill .= 0;
				}
				$bin = $fill . $bin;
			}

			//判断转换成的二进制数是不是 4位
			if (strlen($bins) != 4) {
				//不足 4位，在前面补0
				for ($a = 0; $a < 4-strlen($bins); $a++) { 
					$fills .= 0;
				}
				$bins = $fills . $bins;
			}

			//组合成完整的 64位的二进制数
			$m_binary .= $bin;
			$r_binary .= $bins;
		}

		//计算两张图片有多少个像素不同
		$total = 0;
		for ($i = 0; $i < strlen($m_binary); $i++) { 
			if ($m_binary[$i] != $r_binary[$i]) {
				$total += 1;
			}
		}

		//判断不同之处有到少个。如果不同处小于5处，说明2张图片相似；反之，则说明两张图片不相似
		if ($total < 5) {
			return true;
		}else {
			return false;
		}
		//return $m_binary . "   " . $r_binary;
		//return $total;
	}
}

$phash = new PHAHash();

$aa = $phash->Obtain("./upload/aa/02.jpg");

if($aa){
	$bb = "两张图片相似";
}else{
	$bb = "两张图片不相似";
}
print_r("<pre>");
print_r($bb);