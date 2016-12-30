<?php 
/**
 *  访问者模式
 *  如果你也是第一次看到这个模式可能也感觉绕来绕去
 *  
 *  简单来说就是把当前对象（访问者）作为参数传入另一个对象（被访问者）的函数中
 *  另一个对象（被访问者）再通过接收的对象（访问者对象）调用（访问者的）方法
 *  同时将当前对象（被访问者）作为参数再传回另一个对象（访问者）的函数中
 *  另一个对象（访问者）执行对应的方法 
 *
 *  一句话 当前对象想增加一个方法 不是把他添加在自己的类中 而是把他添加在别的类中
 *  并且让别的类可以访问自己的属性或方法以此来保证该方法的实现
 *
 *	这样做的好处是我们不用去修改具体节点（被访问者）类就可以轻松的为他增加功能
 *	而且具体的访问者类集中了有关的行为（本例中将vip和normal的行为集中到了一起）
 *	避免了将这些行为分散到具体节点类中（分散不利于系统的维护）
 *	但是它真的破坏了封装 你想 访问者必须知道访问者中存在的一些方法和属性
 *	被访问者必须暴露一些自己的操作和内部状态
 * 
 *  访问者模式里的几种角色
 *  抽象访问者角色(Visitor)：
 *  为该对象结构(ObjectStructure)
 *  中的每一个具体元素提供一个访问操作接口。该操作接口的名字和参数标识了
 *  要访问的具体元素角色。这样访问者就可以通过该元素角色的特定接口直接访问它。
 *  				 
 *  具体访问者角色(ConcreteVisitor):实现抽象访问者角色接口中针对各个具体元素角色声明的操作。
 *  抽象节点（Node）角色:该接口定义一个accept操作接受具体的访问者。
 *  具体节点（Node）角色:实现抽象节点角色中的accept操作。
 *  对象结构角色(ObjectStructure)：
 *  这是使用访问者模式必备的角色。它要具备以下特征：能枚举它的元素；可以提供一个高层的接口以允许该访问者
 *  访问它的元素；可以是一个复合（组合模式）或是一个集合，如一个列表或一个无序集合
 *  (在PHP中我们使用数组代替，因为PHP中的数组本来就是一个可以放置任何类型数据的集合)
 *
 *  类图地址：   http://www.processon.com/diagraming/5865bf38e4b0dc8df77d9cdf	
 */



//  定义抽象节点（被访问者抽象类）
abstract class User
{
	//  获得已有积分
	public function getPoint()
	{
		return rand();
	}

	abstract function accect(UserVisitor $visitor);
}

//  具体节点（被访问者实际类）
class VipUser extends User
{
	public function accept(UserVisitor $visitor)
	{
		$visitor->visitVip($this);
	}
}

//  具体节点（被访问者实际类）
class NormalUser extends User
{
	public function accept(UserVisitor $visitor)
	{
		$visitor->visitNormal($this);
	}
}

//  抽象访问者
abstract class UserVisitor
{
	abstract function visitVip(User $user);
	abstract function visitNormal(User $user);
}

//  具体访问者
class PointActVisitor extends UserVisitor
{
	public function visitVip(User $user)
	{
		$user->getPoint() + 10;
	}

	public function visitNormal(User $user)
	{
		$user->getPoint() + 5;
	}
}

//  客户端类（对象结构角色）
class Users
{
	protected $users;

	public function addUser(User $user)
	{
		$this->users[] = $user;
	}

	public function handVisitor(UserVisitor $visitor)
	{
		foreach ($this->users as $user) {
			$user->accept($visitor);
		}
	}
}

$pointActVisitor = new PointActVisitor();
$users = new Users();
$users->addUser(new VipUser());
$users->addUser(new NormalUser());

$users->handleVisitor($pointActVisitor);





