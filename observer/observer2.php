<?php

/**
 *  观察者模式
 *  模式的核心思想是将客户元素（观察者）即发送短息 写入日志
 *  从中心类（主体）即Register类中分离出来
 *  当主体对应的状态发生变化时 观察者需要被通知到
 *  
 *  类图地址： http://www.processon.com/diagraming/585a97b6e4b078015c5666cf
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

//  创建短信观察者类
class TextObserver implements Observer
{
	public function update($observable)
	{
		$status = $observable->getStatus();
		if ($status[0] == Login::REGISTER_SUCCESS) {
			//  发送短信给注册用户
			//  TODO
		}
	}
}

//  创建日志观察者类
class LoggerObserver implements Observer
{
	public function update($observable)
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


//  我们的问题通过观察者模式得到了很好的解决
//  我们可以把Login类方便的迁移到别的系统而不用做太多更改
//  但是你有没有注意到 目前创建的每一个观察者类（TextObserver LoggerObserver）
//  都要调用被观察类中的一个方法（getStatus）
//  这就需要观察者类知道本不必知道的一些信息（观察者类中是否存在getStatus方法？）
//  因为我们的被观察者不仅仅会局限在Login类
//  所以getStatus方法是否存在也是不确定的（别的类可能不需要这个方法）
//  我们在observer3.php解决这个问题