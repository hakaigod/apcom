<?php
namespace App\Error;

use Cake\Error\ExceptionRenderer;
use Exception;
use Cake\Log\Log;
use App\Error\AppErrorController;

class AppExceptionRenderer extends ExceptionRenderer
{
	protected function _getController()
	{
	  //オリジナルのエラーコントローラーを指定
	  return new AppErrorController();
	}

	protected function _template(Exception $exception, $method, $code)
	{
		//ＰＣ用とモバイル用のTemplateを切り替える
		//「src/Template/Error/」の下にあるTemplateファイルを参照している
		$template = 'error500';
		if ($code < 500) {
			$template = 'error400';
		}
		return $this->template = $template;
	}
}
