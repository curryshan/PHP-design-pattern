<?php 
/**
 *  以一个文件结构为例
 *  文件夹下可以存放文件夹（还可以再存文件夹获文件） 也可以存放文件
 *  下面以继承的方式来解决问题
 *
 *  类图地址： http://www.processon.com/diagraming/584b850be4b031ce5439b4cd
 *  
 */

abstract class Container
{
	//  抽象方法 列出容器（文件）的内容
	abstract public function listContent();
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

/*//  我们定义一个普通文件夹来包含这些文件
class CommonDir
{
	//  存储文件对象
	private $files = array();

	public function addFile($file)
	{
		array_push($this->files, $file);
	}

    //  列出所有文件的内容（虽然有点不合理~~~ ^_^）
	public function listContent()
	{
		$ret = '';
		foreach ($this->files as $file) {
			$ret .= $file->listContent();
		}
		return $ret;
	}
}*/

//  如果要加入文件夹的是另一个文件夹怎么办？
//  我们还想实现区分文件夹 因为我们可能又需要移除合并进来的文件夹
//  可以这样解决
//  
//  虽然现在看似很轻松的解决了这个问题 但是随着我们的文件夹和文件类型越来越多
//  不同的文件夹 不同的文件有了自己的特别限制
//  维护这样一个巨大的文件系统 因为继承关系的限制变得很麻烦
//  
//  原因在于我们认为文件夹和文件是不同的两种类型（所以他们不应该继承同一个抽象类Container）
//  我们只好定义一个CommonDir类 用于包含文件类并且被用于其他特定文件夹类的拓展
//  
//  实际上 客户端（调用该类的类）并不需要去区分文件夹里的到底是文件还是文件夹
//  就功能上来说 他们都需要列出内容（listContent）
//  包含其他对象的对象（dir类族）需要有移除和添加其他对象的方法
//  
class CommonDir
{
	//  存储文件对象的数组
	private $files = array();
	//  新增存储文件夹对象的数组
	private $dirs = array();

	public function addFile($file)
	{
		array_push($this->files, $file);
	}

	//  新增添加文件夹方法
	public function addDir($dir)
	{
		array_push($this->dirs, $dir);
	}

    //  列出所有文件的内容（虽然有点不合理~~~ ^_^）
	public function listContent()
	{
		$ret = '';
		foreach ($this->files as $file) {
			$ret .= $file->listContent();
		}
		foreach ($this->dirs as $dir) {
			$ret .= $file->listContent();
		}
		return $ret;
	}
}

class OtherDir Extends CommonDir
{
	//  其他目录类的特定实现
}