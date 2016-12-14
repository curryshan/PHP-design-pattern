<?php 

/**
 *  装饰模式
 *  为了解决通过继承解决问题会造成大量类的产生的问题
 *  我们使用装饰模式
 *  通过组合的方式来替代继承 使类的使用更加灵活
 *  
 * 	类图地址：http://www.processon.com/diagraming/58513ba8e4b0c74cb9f8b0af
 */

abstract class Guitar
{
	abstract public function getPrice();
}

//  木吉他
class LogGuitar extends Guitar
{
	private $price = 1000;

	public function getPrice()
	{
		return $this->price;
	}
}

//  创建吉他装饰抽象类（这个类包裹了真实的guitar对象）
abstract class GuitarDecorator extends Guitar
{
	protected $guitar;

	//  通过构造方法 使其可以储存不同的guitar对象 方便组合
	public function __constract($guitar)
	{
		$this->guitar = $guitar;
	}
}


//  所有的吉他类型都继承自吉他装饰类
class RosewoodGuitar extends GuitarDecorator
{

	public function getPrice()
	{
		return $this->guitar->getPrice()+1000;
	}
}


class ElectricBoxGuitar extends GuitarDecorator
{
	public function getPrice()
	{
		return $this->guitar->getPrice()+1500;
	}
}

//  如果此时我们想得到一个玫瑰木背侧的电箱木吉他 我们可以这样做

$LogGuitar = new LogGuitar();
$RosewoodGuitar = new RosewoodGuitar($LogGuitar);
$ElectricBoxRosewoodGuitar = new ElectricBoxGuitar($RosewoodGuitar);

//  我们只需要将具有单一特性的类定义出来
//  当想使用一个具有多种特性的类的对象时（ElectricBoxRosewoodGuitar）
//  不用为此对象单独定义一个类
//  而是通过对单一特性类的组合来得到具有多种特性的类
//  装饰模式动态的将责任附加到对象上
