<?php
namespace App\View\Helper;
use Cake\View\Helper;
const PREFIX = "text-";
const MAX = 80;

class ScoreColorHelper extends Helper
{
	function getClass($score):string
	{
		if ( $score=== null || !(is_int($score))) {
			return "";
		}
		$textClass = PREFIX;
		if ($score < ( MAX * 0.5 )) {     //0-5割
			$textClass .= "danger";
		}else if ($score < ( MAX * 0.6 )) {     //5-6割
			$textClass .= "warning";
		}else if ($score < ( MAX * 0.8 )){		//6-8割
			$textClass .= "info";
		}else{ //8-10割
			$textClass .= "success";
		}
		return $textClass;
	}
}
