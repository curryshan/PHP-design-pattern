<?php 
/**
 *  我们定义一个问题
 *  有一个活动页面 用户访问就可以增加积分
 *  vip用户每次访问增加10积分
 *  普通用户每次访问增加5积分
 *  我们这样模拟实现 
 *  这和简单 看起来也很完美
 *  但是随着我们网站的用户类型越来越多（svip 特定类型的vip）
 *  我们的用户类会越来越多
 *  一旦我们改变类访问奖励的规则（我们不给积分 直接发红包了或直接发现金了 卧槽~~~）
 *  我们就不得不去修改每一个用户类的实现
 *  那么如何解决这一问题呢  
 *
 *  类图地址：  http://www.processon.com/diagraming/5865be64e4b067ce85048842 
 */



abstract class User
{
	//  获得已有积分
	public function getPoint()
	{
		return rand();
	}

}


class VipUser extends User
{
	public function visitVip()
	{
		$this->getPoint()+10;
	}
}


class NormalUser extends User
{
	public function visitNormal()
	{
		$this->getPoint()+5;
	}
}

//  other userclass





