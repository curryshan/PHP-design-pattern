<?php 

/**
 *  策略模式的应用
 */


// 用组合的方式来解决问题（策略模式）
// http://www.processon.com/diagraming/5842819fe4b0d0d77bee674f


abstract class Lesson
{
	protected $duration;
	//  用于存放一个算法类的实例
	private $costStrategy;

	public function __construct($duration, $costStrategy)
	{
		$this->duration = $duration;
		$this->costStrategy = $costStrategy;
	}

	public function cost()
	{
		$this->costStrategy->cost($this);
	}

	public function chargeType()
	{
		$this->costStrategy->chargeType($this);
	}

	public function getDuration()
	{
		return $this->duration;
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

//  算法抽象类
abstract class CostStrategy
{
	abstract  public function cost(Lesson $lesson);
	abstract  public function chargeType(Lesson $lesson);
}

class FixedCostStrategy
{
	public function cost($lesson)
	{
		return 30;
	}

	 public function chargeType($lesson)
	 {
	 	return 'fixed rate';
	 }
}


class TimeCostStrategy
{
	public function cost(Lesson $lesson)
	{
		return $lesson->getDuration()*5;
	}

	 public function chargeType(Lesson $lesson)
	 {
	 	return 'time rate';
	 }
}


$lesson = new Leture(5, new FixedCostStrategy());
var_dump($lesson);