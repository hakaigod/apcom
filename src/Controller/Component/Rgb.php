<?php
namespace App\Controller\Component;

class Rgb {
	private $red;
	private $green;
	private $blue;
	/**
	 * rgb constructor.
	 * @param $red
	 * @param $green
	 * @param $blue
	 */
	public function __construct( $red, $green, $blue )
	{
		$this->red = (int) ($red * 255);
		$this->green = (int) ($green * 255);
		$this->blue = (int) ($blue * 255);
	}
	/**
	 * @return mixed
	 */
	public function getRed()
	{
		return $this->red;
	}
	/**
	 * @return mixed
	 */
	public function getGreen()
	{
		return $this->green;
	}
	/**
	 * @return mixed
	 */
	public function getBlue()
	{
		return $this->blue;
	}
}
