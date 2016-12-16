<?php 
/**
 * 抽象工厂模式
 * 当我们在创建 SinaEmailServer对象的时候 我们也必然要使用的是StoreSinaEmail对象
 * 虽然这两个对象是实现的处于平行关系 无联系的两个抽象类（EmailSever StoreEmail）
 * 此时这两个抽象类属于一个产品族 而为产品族内不同的产品实现创建联系正是抽象工厂模式解决的问题
 * 可以在类的内部对产品族进行约束（为不同等级机构中的同一产品族创建联系）
 *
 * 抽象工厂模式的缺点也显而易见 
 * 每当添加新的产品到产品族 那么创建者的抽象类和具体实现类都要做出改变
 * 如getStoreEmail方法的出现
 *
 * 类图地址 http://www.processon.com/diagraming/5846730fe4b08e3135d11b26
 */
abstract class EmailMannger
{
	abstract public function getEmailServer();
	abstract public function getEmailUserInfo();
	//  相对于工厂模式新增
	abstract public function getStoreEmail();
}

class SinaEmailManager
{
	public function getEmailServer()
	{
		return new SinaEmailServer();
	}
	public function getEmailUserInfo()
	{
		//  return sina user and password;
	}
	//  相对于工厂模式新增
	public function getStoreEmail()
	{
		return new StoreSinaEmail();
	}
}

class NeteaseEmailManager
{
	public function getEmailServer()
	{
		return new NeteaseEmailServer();
	}
	public function getEmailUserInfo()
	{
		//  return Netease user and password;
	}
	//  相对于工厂模式新增
	public function getStoreEmail()
	{
		return new StoreSinaEmail();
	}
}
//  EmailSever和StoreEmail属于两个不同的等级结构
//  Sina和Netease则属于两个不同的产品族
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
