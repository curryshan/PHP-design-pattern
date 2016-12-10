<?php 
/**
 *  组合模式：将一组对象组合为可像单个对象一样被使用的结构
 *  这样就形成了一种类似于树状的结构
 *  树的根节点就是Container类 所有的实现类都继承自它 无论是文件夹还是文件
 *
 *  类图地址： http://www.processon.com/diagraming/584ac2f6e4b0d594ec73c16f
 */


abstract class Container
{
	//  抽象方法 列出容器（文件夹或文件）的内容
	abstract public function listContent();
	//  用于文件夹类添加新的文件或文件夹
	public function addContainer($Container)
	{
		//  文件夹类会重写这个方法
		//  文件类因为不能作为容器使用（即不能在文件中再添加文件或文件夹）
		//  所以会返回这样一个错误
		exit('该类型不能添加新的容器');
	}
	//  用于文件夹类移除文件或文件夹
	abstract public function removeContainer($Container)
	{
		exit('该类型无法移除容器');
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

//  注意 文件夹类此时也继承Container类 此时将文件夹和文件视作同一种结构
class CommonDir Extends Container
{
	//  这里不用再区分是文件类型还是文件夹类型
	//  统一视作容器类型
	private $containers = array();

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
		//  其实现在我也没看太懂 有点困了 弄完先睡觉
		$this->containers = array_udiff($this->containers, array($container), function ($a,$b) {
			return ($a === $b)?0:1;
		});
	}

	public function listContent()
	{
		$ret = '';
		foreach ($this->containers as $container) {
			$ret .= $container->listContent();
		}
		return $ret;
	}
}

//  其他特殊的文件夹类型不再继承CommonDir 也直接继承Container
class OtherDir Extends Container
{
	//  其它类的特定实现
}



//  这个模式的问题在于文件类（Mp3File TextFile）
//  为了Contrainer类的透明性 
// （指调用这个Contrainer类的代码知道Contrainer类中一定包含addContainer removeContainer方法）
//  文件类必须继承addContainer removeContainer这些自身不可用的方法
//  在composite3.php我们解决这个问题