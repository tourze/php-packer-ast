<?php

namespace PhpPacker\Ast\Visitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * 抽象访问者基类
 */
abstract class AbstractVisitor extends NodeVisitorAbstract implements VisitorInterface
{
    /**
     * 访问者名称
     */
    private string $name;

    /**
     * @param string|null $name 访问者名称，如果为null则使用类名
     */
    public function __construct(?string $name = null)
    {
        $this->name = $name ?? (new \ReflectionClass($this))->getShortName();
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 设置访问者名称
     *
     * @param string $name 新的名称
     * @return self 当前对象，支持链式调用
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * 默认实现，不修改节点
     */
    public function leaveNode(Node $node)
    {
        return null; // 返回null表示不修改AST
    }
}
