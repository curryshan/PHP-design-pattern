<?php

/**
 *  观察者模式
 *  先用一个应用场景引出这个模式
 *  有一个处理注册的类
 *  我们在处理注册的过程中也会需要一些其他的功能
 *  比如注册成功发送验证短信
 *  注册失败写入错误日志
 *  等等等等
 *  随着这些附加的操作越来越多
 *  我们发现这个主要用来注册用户的类中有了太多的其它操作
 *  这就导致Register类会紧紧的嵌入到当前系统中
 *  如果要把这个Register功能提取出来用于别的系统
 *  需要逐行的检查代码然后选择性提取（你知道这有多麻烦 多易出错吧？）
 *  噔噔噔噔 观察者模式在observer2.php中登场。
 *
 *  类图地址： 我觉得这个不用类图 ^_^
 */

class Register
{
	const REGISTER_SUCCESS = 1;
	const REGISTER_FAILD = 2;
	private $status = array();

	//  处理注册（没有具体实现 用随机函数模拟实现）
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

		if ($ret) {
			//  注册成功发送短信
			Text::send('register success', $tel);
		} else {
			//  注册失败写入错误日志
			Logger::log('register faild', $this->status);
		}
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