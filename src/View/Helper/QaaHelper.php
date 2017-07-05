<?php
/**
* qaaQuestionで利用するヘルパー
* Created by PhpStorm.
* User: 15110014
* Date: 2017/06/28
* Time: 10:42
*/
namespace App\View\Helper;
use Cake\View\Helper;
class QaaHelper extends Helper
{
    function viewTextImg(string $content):string
    {
        return str_replace('<?= $this->request->webroot ?>',
            $this->request->getAttribute("webroot") ,$content);
    }
}
