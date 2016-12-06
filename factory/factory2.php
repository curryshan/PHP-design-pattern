<?php 
/**
 * 用工厂模式解决factory1.php重复使用条件语句的问题
 * 工厂方法模式把创建者（EmailMannger）和要生产的产品类分离开（SinaEmailServer NeteaseEmailServer）
 * 将EmailManager抽象为抽象类 针对每一个服务器 创建不同的管理子类
 */
abstract class EmailMannger
{
	public function getEmailServer();
	public function getEmailUserInfo();
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
}

abstract class EmailSever
{
	public function sendEmail();
	public function reciveEmail();
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


