<?php 
/**
 *  命令模式
 *  我们可以想象这样一个场景
 *  我们需要每周备份一次服务器上的数据库文件
 *  当然 我们首先得有一台操作正常的服务器
 *  我们可以选择每周五下班前自己来备份
 *  当然 我们还可以选择系统自带的命令来自动备份
 *  比如linux下好用的crontab
 *  这次我们不对比了 直接来命令模式
 *  实际上我有点想不出来怎么对比 @_@ @_@
 *
 * 	类图地址：  http://www.processon.com/diagraming/5868fe4ee4b067ce851a9739
 *
 *	你可以看完代码示例再看下边
 *	命令模式中有五种角色
 *	抽象命令 具体命令 调用命令者 接收命令者 客户端
 *
 * 	@1 Command抽象类对应抽象命令的角色
 * 	它定义了所有具体命令的规范 所有具体命令都要继承他
 * 	@2 AutomaticCommand类对应具体命令的角色
 * 	他的实现方法（excute）是一种“虚”的方法 
 * 	其实他是调用命令的接收者（具体执行者）里的执行方法（doThings） 来执行命令
 *  @3 Person类对应调用命令者的角色
 *  他接收一条命令 并且调用命令的执行方法（execute）来执行命令
 *  @4 DatabaseReciver类对应接收命令者
 *  他是命令的具体执行者 实现了命令（备份）执行的细节
 *  @5 Server类对应客户端角色
 *  他可以调用直接执行命令 也可以调用调用者（人）执行命令
 *
 * 	不知道你有没有发现
 * 	命令模式使我们对于命令的拓展操作更加符合对修改封闭，对扩展开放的原则
 * 	我们新增一个命令只要新建一个类即可完成
 * 	但是这不是命令模式出现的主要原因
 *  关键是我们使调用命令者和执行命令者（接收命令者）之间的耦合更松
 *  因为他们中间有了具体命令执行者这个角色
 *  调用者可以通过具体命令执行者去调用多种不同的命令
 *  我们可以改动调用者 也可以改动接收命令者（这很有可能）
 *  而不用担心一方的改动会影响另一方的操作 （只需修改具体命令执行者）
 *  当然命令模式也会带来系统中命令类过多等缺点
 */

class Person
{
	private $command;

	// 管理人员设置自动备份的命令
	public function setCommand(Command $command)
	{	
		$this->command = $command;
	}

	//  管理人员执行命令
	public function doCommand()
	{
		$this->command->execute();
	}
}


//  命令抽象类（所有命令都要有执行方法）
abstract class Command
{
	abstract function execute();
}

//  自动执行命令（比如crontab命令）
class AutomaticCommand extends Command
{
	private $databaseReciver;

	public function __contruct(DatabaseReciver $databaseReciver)
	{
		$this->databaseReciver = $databaseReciver;
	}

	public function excute()
	{
		$this->databaseReciver->doThings();
	}
}

//  数据库系统
class DatabaseReciver
{
	public function doThings()
	{
		echo  'The database being backed up';
	}
}

//  服务器类
class Server
{
	public function index()
	{
		//  先创建一个命令的接收者（数据库系统对象） 即命令的具体执行者  
		$databaseReciver = new DatabaseReciver();
    	//  接收者绑定到具体命令对象（自动备份命令）里 执行方法将调用接收者（数据库系统）的具体方法（备份）
		$commend = new AutomaticCommand($databaseReciver);

		//  两种执行命令的方式
    	//客户端直接执行具体命令方式（服务器直接通过自动执行命令备份数据库）  
		$commend->excute();

    	//客户端通过调用者来执行命令  （服务器依赖人来执行备份 类图就是这种方式）
		$personInvoker = new Invoker();
		$personInvoker->setCommand($commend);
		$personInvoker->doCommand();
	}
}

/**
 * 
 */