<?php 

/**
 *  策略模式的应用
 */


// 用继承的方式来解决问题
// http://www.processon.com/diagraming/584278fee4b08e3135a7fd7a


abstruct class Lesson
{
	protected $duration;
	const FIXED = 1;
	const TIMED =2;
	private $costtype;

	public function __construct($duration, $costtype=1)
	{
		$this->duration = $duration;
		$this->costtype = $costtype;
	}

	public function cost()
	{
		switch ($this->costtype) {
			case self::FIXED :
				return 30;
				break;
			case self::TIMED :
				return (5 * $this->$duration);
				break;
			default :
				$this->costtype = self::FIXED;
				return 30;
		}
	}

	public function chargeType()
	{
		switch ($this->costtype) {
			case self::FIXED :
				return "fixed rate";
				break;
			case self::TIMED :
				return "hourly rate";
				break;
			default :
				$this->costtype = self::FIXED;
				return "fixed rate";
		}
	}

	//  Lesson的更多方法
}


class Leture extends Lesson
{
	//  Leture的特定实现
}

class Seminar extends Lesson
{
	//  Seminar的特定实现
}



