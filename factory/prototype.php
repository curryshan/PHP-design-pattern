<?php 
/**
 * 原型模式
 * 使用抽象工厂模式时每当添加新的产品到产品族 那么创建者的抽象类和具体实现类都要做出改变
 * 而且必须通过客户端或者配置文件来决定到底调用哪一个具体的创建者 （事实上原型模式也没有解决这个问题 只是简化了过程 减少了创建者子类的创建）
 * 这是用继承关系带来的不可避免的问题 为了解决这个问题 原型模式登场 噔噔噔噔
 * 这一这里的clone是浅复制（不会复制对象的引用）
 *
 * 类图地址 http://www.processon.com/diagraming/5846aa07e4b0d0d77c1c36bb
 */
class EmailMannger
{
	//  新增两个属性 用于保存两个对象 作为原型供克隆使用
	private $EmailServer;
	private $StoreEmail;

	//  构造方法 初始化原型对象
	public function __construct($emailServer, $storeEmail)
	{
		$this->EmailServer = $emailServer;
		$this->StoreEmail = $storeEmail;
	}

	public function getEmailServer()
	{
		return clone $this->EmailServer;
	}
	public function getEmailUserInfo()
	{
		// fuck这个怎么弄？？ 我再想想
		// 玛德 估计又得条件判断了
	}
	public function getStoreEmail()
	{
		return clone $this->StoreEmail;
	}
}


//  一个产品类 EmailServer抽象类
abstract class EmailSever
{
	abstract public function sendEmail();
	abstract public function reciveEmail();
}

class SinaEmailServer
{
	public function sendEmail()
	{
		return 'send Sina Email';
	}

	public function reciveEmail()
	{
		return 'recive Sina Email';
	}
}

class NeteaseEmailServer
{
	public function sendEmail()
	{
		return 'send Netease Email';
	}

	public function reciveEmail()
	{
		return 'recive Netease Email';
	}
}

//  另一个产品类 导出邮箱所有邮件 每个服务器的邮件单独保存在一个位置
abstract class StoreEmail
{
	abstract public function getAllEmail();
	abstract public function storeAllEmail();
}

class StoreSinaEmail
{
	public function getAllEmail()
	{
		return 'get all SinaEmail';
	}
	public function storeAllEmail()
	{
		eturn 'store all SinaEmail to Sina dir';
	}
}

class StoreNeteaseEmail
{
	public function getAllEmail()
	{
		return 'get all NeteaseEmail';
	}
	public function storeAllEmail()
	{
		eturn 'store all NeteaseEmail to Netease dir';
	}
}