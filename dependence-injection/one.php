<?php 

//  在学习深入理解Yii2.0的时候接触到服务定位器（service locator）概念
//  所以有了一下一系列概念和思考
//  这样一个简单的例子
//  有三个类 A B C 我们需要调用C类来实现一些功能
//  但是C类需要调用B类来完全实现
//  而B类需要调用A类来完全实现
//  我们的代码很有可能是这样的


class A
{
	public function doSomething()
	{
		echo 'class A do something';
	}
}

class B
{
	public function doSomething()
	{
		$classA = new A();
		$classA->doSomething();
		echo 'class B doSomething';
	}
}

class C
{
	public function doSomething()
	{
		$classB = new B();
		$classB->doSomething();
		echo 'class C doSomething';
	}
}

$classC = new C();
$classC->doSomething();

//  这实现起来很简单 但是我们来看下它可能会存在什么问题
//  我们很容易得出这样的依赖关系
//  C 依赖于 B   B 依赖于 A 
//  我们的项目中主要调用C类来处理逻辑
//  C类是最上级的模块 C类用到的数据会用到B类这个下级模块
//  和A类这个下下级模块来帮助组织
//  所以一旦A类模块发生变化 那么B类肯定要做出相应变化
//  同理 C类模块的变化也就在所难免了
//  但是作为C类的最上级模块往往写有很多很复杂的逻辑（比如组织数据）
//  我们不希望仅仅因为一个底层小模块的改变便对最高层模块做出改变
//  那么如何解决这个问题？