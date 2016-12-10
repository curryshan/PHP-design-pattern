<?php 
/**
 * 解决方法 为文件夹类型独立建立一个抽象类 将add和remove方法从Container类中移除
 *
 * 类图地址： http://www.processon.com/diagraming/584bb44ce4b031ce543ba9d7
 */


abstract class Container
{
	abstract public function listContent();
	//  用于区分文件类型或文件夹类型的方法
	public function getComposite()
	{
		return null;
	}
	
}

//  mp3类型文件
class Mp3File Extends Container
{
	public function listContent()
	{
		return 'play music';
	}
}

//  txt类型文件
class TxtFile Extends Container
{
	public function listContent()
	{
		return 'list word';
	}
}

//  为文件夹类型独立建立一个抽象类(因为未能实现listContent方法)
abstract class DirContrainer
{
	private $contrainers = array();

	//  重写父类的方法 不让返回Null 而返回自身 用于继续操作
	public function getComposite()
	{
		return $this;
	}

	public function addContainer($container)
	{
		//  已存在拒绝添加
		if (in_array($Container, $this->containers, true)) {
			return;
		}
		$this->containers[] = $container;
	}

	public function removeContainer($container)
	{
		$this->containers = array_udiff($this->containers, array($container), function ($a,$b) {
			return ($a === $b)?0:1;
		});
	}

}

//  文件夹类不再直接继承Contrainer类 而是继承DirContrainer类
class CommonDir Extends DirContrainer
{
	//  普通类的特殊操作
}

class OtherDir Extends DirContrainer
{
	//  其它类的特定实现
}


 // 即便是这样 在客户端调用时 还是要先调用getComposite方法来判断
$demo = new CommonDir();

if ($demo->getComposite != null) {
	//进行添加容器或删除容器等操作
}