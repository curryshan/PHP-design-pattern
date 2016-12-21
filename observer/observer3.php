<?php

/**
 *  观察者模式
 *  观察者类（TextObserver LoggerObserver）调用被观察类中的一个方法（getStatus）
 *  造成的这需要观察者类知道本不必知道的一些信息的问题
 *  
 *  我们可以拓展Observable接口 在其中加入getStatus方法 来保证该方法存在
 *  但是我们希望Obserable接口更抽象 更具有通用性 
 *  所以我们将保证主体（被观察者）是正确类型这一任务交给观察者这一边来处理
 *  
 *  类图地址：http://www.processon.com/diagraming/585a9ff8e4b03a03b186b38c
 */

//  被观察者的接口 定义操作观察者（添加 删除 通知等）的方法
interface Observable
{
	function attach($observer);
	function detach($observer);
	function notify();
}

class Login implement Observer
{
	// 用于储存观察者对象
	private $observers;

	const REGISTER_SUCCESS = 1;
	const REGISTER_FAILD = 2;
	private $status = array();

	public function __construct()
	{
		$this->observers = array();
	}

	//  添加观察者
	public function attach($observer)
	{
		$this->observers[] = $observer;
	}

	//  移除观察者(其实这里我有点不明白他为什么这样)
	public function detch($observer)
	{
		foreach ($this->observers as $obs) {
			if ($observer !== $obs) {
				$newObservers[] = $obs;
			}
		}
		$this->observers = $newObservers;
	} 

	//  通知观察者执行相关操作
	public function notify()
	{
		foreach ($this->observers as $obs) {
			$obs->update($this);
		}
	}

	public function handleRegister($userName, $pass, $tel)
	{
		switch (rand(1,2)) {
			case 1:
			$this->setStatus(SELF::REGISTER_SUCCESS, $userName, $tel);
			$ret = true;
			break;
			case 2:
			$this->setStatus(SELF::REGISTER_FAILD, $userName, $tel);
			$ret = false;
			break;
		}
		return $ret;
		//  这里变为了直接调用notify方法 解除了耦合
		$this->notify();
	}

	private function setStatus($status, $userName, $tel)
	{
		$this->status = ($status, $userName, $tel);
	}

	public function getStatus()
	{
		return $this->status;
	}
}

//  定义观察者接口
interface Observer
{
	function update($servable);
}

//  新增的登录观察者抽象类
abstract class LoginObserver implements Observer
{
	//  用于储存主体类（被观察者类 Login）
	private $login;

	public function __construct($login)
	{	
		$this->login = $login;
		//  注意这里 代表将自身（一个观察者对象 附加到了观察者类 牛逼！！）
		$login->attach($this);
	}

	public function update($observable)
	{
		//  在这里实现了保证主体（被观察者）是正确类型的功能
		if ($observable === $this->login) {
			$this->doUpdate($observable);
		}
	}

	//  具体执行操作的方法
	public function doUpdate($servable);

}


//  创建短信观察者类
class TextObserver extends LoginObserver
{
	public function doUpdate($observable)
	{
		$status = $observable->getStatus();
		if ($status[0] == Login::REGISTER_SUCCESS) {
			//  发送短信给注册用户
			//  TODO
		}
	}
}

//  创建日志观察者类
class LoggerObserver extends LoginObserver
{
	public function doUpdate($observable)
	{
		$status = $observable->getStatus();
		if ($status[0] == Login::REGISTER_FAILD) {
			//  记录错误日志到系统中
			//  TODO
		}
	}
}

//  客户端调用
$login = new Login();
$login->attach(new TextObserver());
$login->attach(new LoggerObserver());

//  在执行handleRegister时 会根据结果自动决定发送短信还是记录错误日志
$login->handleRegister('shan', '123', '157****0563');

//  在画类图的时候我遇到了组合和聚合概念不清楚的问题
//  通过学习搞懂了 在这记录下

/*
组合和聚合是有很大区别的，这个区别不是在形式上，而是在本质上
比如A类中包含B类的一个引用b，当A类的一个对象消亡时，
b这个引用所指向的对象也同时消亡（没有任何一个引用指向它，成了垃圾对象)
这种情况叫做组合。
反之b所指向的对象还会有另外的引用指向它，这种情况叫聚合。
在实际写代码时
组合方式：
    A类的构造方法里创建B类的对象，也就是说，当A类的一个对象产生时，B类的对象随之产生，当A类的这个对象消亡时，它所包含的B类的对象也随之消亡。
聚合方式：
    A类的对象在创建时不会立即创建B类的对象，而是等待一个外界的对象传给它
    传给A的这个对象不是由A类创建的。
*/