<?php 

/**
 * 工厂模式
 * 工厂模式要解决的问题
 */

//  以个人的信息处理为例，一个人可以处理邮件信息（新浪邮箱 网易邮箱） 即时信息（qq消息 微信消息 短信）

//  首先以邮件管理为例(差的解决方法)
//  类图地址 http://www.processon.com/diagraming/58456abee4b0d0d77c0b1108

class EmailMannger
{
	//  定义两个常量用于选择实例化服务器对象
	const SINA = 1;
	const NETEASE = 2;
	//  用于存放服务器对象
	private $_serverMode; 

	public function __construct($serverMode)
	{	
		$this->_server = $serverMode;
	}

	//  判断到底要实例化哪个对象这个问题仍然需要客户端来处理（$serverMode）
	//  因为代码只有在运行时才知道要创建哪个对象（而不是在类被定义时）
	//  当这个类中需要的功能越来越多时 这种条件语句在每个类中都会重复
	public function getEmailServer()
	{
		switch ($this->_server) {
			case (self::SINA) :
			return new SinaEmailServer();
			break;
			case (self::NETEASE) :
			return new NeteaseEmailServer();
			break;
		}
	}
	public function getEmailUserInfo()
	{
		switch ($this->_server) {
			case (self::SINA) :
			//  return sina user and password;
			break;
			case (self::NETEASE) :
			//  return Netease user and password;
			break;
		}
	}

	//  更多功能 都要判断服务器类型
}

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