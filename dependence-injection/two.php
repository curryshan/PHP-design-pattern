<?php 

//  为了解决上述问题 我们引入依赖导致原则(Dependence Inversion Principle, DIP)
//  依赖导致的核心思想是上层定义接口 下层实现这个接口
//  从而使得下层依赖于上层 降低耦合度
//  控制反转(Inversion of Control, IoC)是实现DIP的一种方法
//  核心思想是将上层模块所依赖的下层模块的实例化过程交给第三方来实现
//  简单点说就是上层模块中不会有NEW 依赖的下层模块的语句出现
//  依赖注入(Dependence Injection, DI)是实现IoC的一种设计模式
//  核心思想是把上层模块所依赖的下层模块的实例化过程,放到类的外边去实现
//  依赖注入的实现具体有三种方式
//  接口注入 setter注入 构造方法注入
//  以下以构造方法注入

class A
{
	public function doSomething()
	{
		echo 'class A do something';
	}
}

class B
{
	private $classA;
	
	public function __construct($classA)
	{
		$this->classA = $classA;
	}
	public function doSomething()
	{
		$this->classA->doSomething();
		echo 'class B doSomething';
	}
}

class C
{
	private $classB;
	
	public function __construct($classB)
	{
		$this->classB = $classB;
	}

	public function doSomething()
	{
		$this->classB->doSomething();
		echo 'class C doSomething';
	}
}

$classC = new C(new B(new A()));
$classC->doSomething();

//  这样我们就可以通过注入不同的底层模块
//  来实现不同的组合
//  一旦我们依赖的底层模块发生改变
//  我们只需要在实例化最高级模块时填入不同的对象即可
//  C类的构造方法相当于提供了一种抽象
//  C类不关心传入的对象具体是什么样的
//  只要你来自实例化自B类 随意！