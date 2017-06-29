<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Exception\Exception;

/**
 * Identicon component
 */
//生成画像の一辺の長さ
const IM_SIZE = 385;
//一方向辺りの点の数
const RECT_NUM = 5;
//各点の大きさ
const PIXEL_SIZE = IM_SIZE / RECT_NUM;
//生成画像の一辺あたりの空白
const SPACE = 35;
//生成先ディレクトリ名
const DIR_NAME = 'identicons';
//背景色
const BG_COLOR = [245,245,245];
//塗る色の彩度
const SAT = 121;
//塗る色の明度
const VAL = 200;
class IdenticonComponent extends Component
{

	/**
	 * Default configuration.
	 *
	 * @var array
	 */
	protected $_defaultConfig = [];

	public function makeImage (string $s_code) {

		$array = $this->convert($s_code);
		$image = $this->paint($array);
		$dirArray = [ "private", "img", DIR_NAME];
		//保存するディレクトリの存在確認
		$dirPath = implode(DIRECTORY_SEPARATOR, $dirArray);
		if ( !( file_exists($dirPath) ) ) {
			throw new Exception("ディレクトリが存在しません");
		}
		//ファイル名を含めたファイルパス
		$filePath = $dirPath . DIRECTORY_SEPARATOR . $s_code . ".png";
		if ( !( imagepng($image, $filePath) ) ) {
			throw new Exception("画像保存　失敗 at " . $s_code);
		}
		//メモリから消去
		imagedestroy($image);
	}
	//ここまで使用例
	function paint (array $array){
		//真っ黒の画像を生成
		$image = imagecreatetruecolor(IM_SIZE + 2 * SPACE,IM_SIZE + 2 * SPACE) or die('Cannot start generation an icon');
		//灰色に塗りつぶす
		$gray = imagecolorallocate($image, BG_COLOR[0],BG_COLOR[1],BG_COLOR[2]);
		imagefill($image, 0, 0, $gray);
		//0 <= S,V <= 1に変換
		$hsv = new Hsv($array['hue'], SAT/256, VAL/256);
		//色空間をHSVからRGBに変換
		$rgb = $this->hsv2rgb($hsv);
		$color = imagecolorallocate(
			$image,
			$rgb->getRed(),
			$rgb->getGreen(),
			$rgb->getBlue()
		);
		//与えられた座標に四角形を描画
		foreach ($array as $point) {
			if (gettype($point) != 'array') {
				continue;
			}
			imagefilledrectangle($image,
			                     $point[0] * PIXEL_SIZE + SPACE,
			                     $point[1] * PIXEL_SIZE + SPACE,
			                     ($point[0] + 1) * PIXEL_SIZE + SPACE,
			                     ($point[1] + 1) * PIXEL_SIZE + SPACE,
			                     $color);
		}
		return $image;
	}
	function convert ($s_code) : array
	{
		$hashed = md5($s_code);
		//戻り値となる、塗るべき座標
		$ar = [];
		//画像のセンターとなる座標
		$center = ceil(RECT_NUM / 2);
		//i文字目がUnicodeで偶数ならば座標追加
		for ( $i = 0; $i < RECT_NUM * $center; $i++ ) {
			if ( ord($hashed[ $i ]) % 2 === 0 ) {
				$pt_x = (int)floor($i / RECT_NUM);
				$pt_y = $i % RECT_NUM;
				array_push($ar, [ $pt_x, $pt_y ]);
				//もし真ん中より左だったら
				if ( $pt_x < $center - 1 ) {
					//左右反転して追加
					array_push($ar, [ ( RECT_NUM - 1 ) - $pt_x, $pt_y ]);
				}
			}
		}
		$sum = 0;
		//語尾から七文字を色相決定に利用する
		for($i = 0; $i < 7; $i++) {
			$sum += ord($hashed[strlen($hashed) - 1 - $i]);
		}
		$ar['hue'] = $sum % 256;

		return $ar;
	}

	function hsv2rgb(Hsv $color) :Rgb {
		$h = $color->getHue();
		$s = $color->getSat();
		$v = $color->getVal();
		if ( $s == 0 ) {
			$rgb = new Rgb($v, $v, $v);
		} else {
			$h = $h % 360 / 360;
			if ($h < 0) {
				$h = $h + 1;
			}
			$var_h = $h * 6;
			$i = (int)$var_h;
			$f = $var_h - (int)$var_h;
			$p = $v * ( 1 - $s );
			$q = $v * ( 1 - $s * $f );
			$t = $v * ( 1 - $s * ( 1 - $f ) );
			switch($i){
				case 0:
					$rgb = new Rgb($v, $t, $p);
					break;
				case 1:
					$rgb = new Rgb($q, $v, $p);
					break;
				case 2:
					$rgb = new Rgb($p, $v, $t);
					break;
				case 3:
					$rgb = new Rgb($p, $q, $v);
					break;
				case 4:
					$rgb = new Rgb($t, $p, $v);
					break;
				default:
					$rgb = new Rgb($v, $p, $q);
			}
		}
		return $rgb;
	}
}
