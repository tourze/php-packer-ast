<?php

namespace PhpPacker\Ast\Tests\Visitor;

use PhpPacker\Ast\Visitor\RenameDebugInfoVisitor;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassMethod;
use PHPUnit\Framework\TestCase;

class RenameDebugInfoVisitorTest extends TestCase
{
    private RenameDebugInfoVisitor $visitor;

    protected function setUp(): void
    {
        $this->visitor = new RenameDebugInfoVisitor();
    }

    public function testGetName(): void
    {
        $this->assertEquals('RenameDebugInfoVisitor', $this->visitor->getName());
    }

    public function testRenameMethodCall(): void
    {
        // 创建一个方法调用节点，模拟 $obj->__debugInfo()
        $methodCall = new MethodCall(
            new Node\Expr\Variable('obj'),
            new Identifier('__debugInfo')
        );

        // 通过访问者处理节点
        $this->visitor->leaveNode($methodCall);

        // 验证方法名已更改
        $this->assertEquals('not_support_in_kphp__debugInfo', $methodCall->name->name);
    }

    public function testRenameClassMethod(): void
    {
        // 创建一个类方法节点，模拟 public function __debugInfo() {}
        $classMethod = new ClassMethod(
            new Identifier('__debugInfo')
        );

        // 通过访问者处理节点
        $this->visitor->leaveNode($classMethod);

        // 验证方法名已更改
        $this->assertEquals('not_support_in_kphp__debugInfo', $classMethod->name->name);
    }

    public function testDoNotRenameOtherMethodCall(): void
    {
        // 创建一个其他方法调用节点，模拟 $obj->otherMethod()
        $methodCall = new MethodCall(
            new Node\Expr\Variable('obj'),
            new Identifier('otherMethod')
        );

        // 保存原方法名
        $originalName = $methodCall->name->name;

        // 通过访问者处理节点
        $this->visitor->leaveNode($methodCall);

        // 验证方法名未更改
        $this->assertEquals($originalName, $methodCall->name->name);
    }
}
