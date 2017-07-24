<?php
namespace App\View\Helper;
use Cake\View\Helper;

const MEDAL_NAMES = ["first.svg","second.svg","third.svg"];
class ScoreMedalHelper extends Helper\HtmlHelper
{
	function getImage($rank):string {
		if ($rank < 1) {
			return "";
		}else if ($rank <= count(MEDAL_NAMES) ) {
			return $this->image(MEDAL_NAMES[$rank-1], ['alt' => $rank, "width" => "32px", "height"=> "32px"]);
		}else{
			return $rank;
		}
	}
}