<?php 

/**
 * 注册器（注册树 注册表）模式
 * 今天偷点懒啊 来个简单点的模式
 * 但是这个模式的应用也是非常广泛的
 * 我们来想象一个这样的场景
 * 现在我们来到70年代的某个山村小学
 * 学校虽小但是各个职能部门很全
 * 由于设施落后部门间相互通知依赖着学校中间的一块布告板
 * 各个部门都能在布告板上增加和删除布告
 *
 * 这个布告板就相当于一个注册器
 * 特定范围（比如整个系统）中的所有的类都可以访问这个注册器的内容
 * 也可以增加或删除信息（我们会有一些限定规则）
 * 就算是真实的学校布告板也不能随便添加删除布告啊是吧？
 *
 * 也许你会好奇为什么要把注册器做成单例模式
 * 通过这种方式 我们把这个注册器变成了一种特殊的全局变量
 * 保证了这个类只有一个实例被全局访问
 * 也就是保证我们的学校只有这一个布告板 
 * 而不是每个部门都在自己的布告板上操作（相当于每个类在自己的类中new Board生成board对象）
 *
 * 类图地址：  不会吧 这么简单你还想看类图？我学学一些偷懒的老师：这个留给同学们作为课后作业 ^_^
 */

class Board
{
	public static $instance;
	public $infos = array();

	private function __construct()
	{

	}
	public static function getInstance()
	{
		if (!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function set($key, $value){  
		$this->infos[$key] = $value;  
	}  
	
	public function get($key){  
		return isset($this->infos[$key]) ? $this->infos[$key] : null;  
	} 
}

class Abanch
{
	public function setInfo($messageCode=0, $messageContent='')
	{
		$board = Board::getInstance();
		$board->set($messageCode,$messageContent);
	}

	public function getInfo($messageCode=0)
	{
		$board = Board::getInstance();
		return $board->get($messageCode);
	}
}

class Bbanch
{
	public function setInfo($messageCode=0, $messageContent='')
	{
		$board = Board::getInstance();
		$board->set($messageCode,$messageContent);
	}

	public function getInfo($messageCode=0)
	{
		$board = Board::getInstance();
		return $board->get($messageCode);
	}
}

$abanch = new Abanch();
$abanch->setInfo(1,'The restaurant has meat');
$bbanch = new Bbanch();
$info = $bbanch->getInfo(1);
var_dump($info);

