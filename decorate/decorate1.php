<?php 

/**
 *  装饰模式
 *  我们以吉他为例 吉他分为原木吉他 和 电吉他 
 *  根据配置 原木吉他又有 单板吉他 电箱吉他 玫瑰木吉他等
 *
 * 	类图地址： http://www.processon.com/diagraming/5851300ae4b050f1230632d1
 */

abstract class Guitar
{
	//  每种乐器都会有价格
	abstract public function getPrice();
}

//  木吉他
class LogGuitar extends Guitar
{
	//  原木吉他价格大致为1000元
	private $price = 1000;

	public function getPrice()
	{
		return $this->price;
	}
}

//  玫瑰木背侧板的吉他
//  因为玫瑰木背侧板的吉他属于木吉他的一种 我们自然想到拓展LogGuitar类
class RosewoodGuitar extends LogGuitar
{
	//  玫瑰木背侧板的2000元
	public function getPrice()
	{
		return parent::getPrice()+1000;
	}
}

//  电箱吉他
class ElectricBoxGuitar extends LogGuitar
{
	//  电箱吉他2500元
	public function getPrice()
	{
		return parent::getPrice()+1500;
	}
}


//  到现在为止我们的问题通过继承都得到了很好的解决
//  无论什么类型的木吉他 我们只要继承LogGuitar并重写getPrice方法就可以解决
//  但是如果我们想要得到一个玫瑰木背侧板的电箱吉他呢？
//  我们或许可以创建一个叫 ElectricBoxRosewoodGuitar类
//  但是木吉他的配置有很多种（桃花心木 枫木 面单 全单...）
//  如果每次出现一个新的木吉他配置组合我们就要创建一个新类
//  那么系统中仅LogGuitar这一个类就会有数不清的子类
//  而且一旦出现改变（比如玫瑰木的价格上涨了）
//  那么像RosewoodGuitar类 ElectricBoxRosewoodGuitar类 SingleBoardGuitar类等等
//  包含玫瑰木的类价格都需要改变
//  如何解决这个问题呢？

