<?php
namespace App\Controller\Component;

class Hsv {
	private $hue;
	private $sat;
	private $val;
	/**
	 * Hsv constructor.
	 * @param $hue
	 * @param $sat
	 * @param $val
	 */
	public function __construct( $hue, $sat, $val )
	{
		$this->hue = $hue;
		$this->sat = $sat;
		$this->val = $val;
	}
	/**
	 * @return mixed
	 */
	public function getHue()
	{
		return $this->hue;
	}
	/**
	 * @return mixed
	 */
	public function getSat()
	{
		return $this->sat;
	}
	/**
	 * @return mixed
	 */
	public function getVal()
	{
		return $this->val;
	}
}
