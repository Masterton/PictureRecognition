<?php 

/**
 * 尺度不变特征变换匹配算法(Scale-invariant feature transform或SIFT)
 * @author louds
 * @access public
 * @version 0.0.1
 *
 */
class SIFT {

	/**
	 * 高斯模糊（高斯平滑），未使用sigma，边缘无处理
	 * @param $path 图片的地址
	 * @param $sigma σ是正态分布的标准差，σ值越大，图像越模糊(平滑)
	 * @return 
	 *
	 */
	public function GaussianBlur($path, $sigma) {

		//高斯模板(7*7),sigma = 0.84089642，归一化后得到
		$gaussianTemplate = [
	        [0.00000067, 0.00002292, 0.00019117, 0.00038771, 0.00019117, 0.00002292, 0.00000067],
	        [0.00002292, 0.00078633, 0.00655965, 0.01330373, 0.00655965, 0.00078633, 0.00002292],
	        [0.00019117, 0.00655965, 0.05472157, 0.11098164, 0.05472157, 0.00655965, 0.00019117],
	        [0.00038771, 0.01330373, 0.11098164, 0.22508352, 0.11098164, 0.01330373, 0.00038771],
	        [0.00019117, 0.00655965, 0.05472157, 0.11098164, 0.05472157, 0.00655965, 0.00019117],
	        [0.00002292, 0.00078633, 0.00655965, 0.01330373, 0.00655965, 0.00078633, 0.00002292],
	        [0.00000067, 0.00002292, 0.00019117, 0.00038771, 0.00019117, 0.00002292, 0.00000067]
	    ];
	}

	/**
	 * SIFT算法第一步：图像预处理（金字塔初始化）
	 *
	 *
	 *
	 */
	public function ScaleInitImage() {

	}

	/**
	 * SIFT算法第二步：建立高斯金字塔函数（建立高斯金字塔）
	 *
	 *
	 *
	 */
	public function doubleSizeImage() {

	}

	/**
	 * SIFT算法第三步：特征点位置检测，最后确定特征点的位置
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * SIFT算法第四步：计算高斯图像的梯度方向和幅值，计算各个特征点的主方向
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * SIFT算法第五步：进行方向直方图统计
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * SIFT算法第六步：对方向直方图滤波
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * SIFT算法第七步：确定真正的主方向
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * SIFT算法第八步：确定各个特征点处的主方向函数
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * 显示主方向
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * SIFT算法第五步：抽取各个特征点处的特征描述字
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}

	/**
	 * 为了显示图像金字塔，而作的图像水平、垂直拼接
	 *
	 *
	 *
	 */
	public function doubleSizeImage2() {

	}
}