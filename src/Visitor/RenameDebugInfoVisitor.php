<?php

namespace PhpPacker\Ast\Visitor;

use PhpParser\Node;

/**
 * 重命名__debugInfo方法的访问者，用于适配KPHP
 */
class RenameDebugInfoVisitor extends AbstractVisitor
{
    /**
     * 重命名后的新名称
     */
    private const NEW_NAME = 'not_support_in_kphp__debugInfo';

    public function leaveNode(Node $node)
    {
        // 检查节点是否是方法调用，且名称为 __debugInfo
        if ($node instanceof Node\Expr\MethodCall &&
            $node->name instanceof Node\Identifier &&
            $node->name->name === '__debugInfo') {
            // 修改方法名为 not_support_in_kphp__debugInfo
            $node->name->name = self::NEW_NAME;
        }

        // 如果是类方法声明，也进行替换
        if ($node instanceof Node\Stmt\ClassMethod &&
            $node->name->name === '__debugInfo') {
            $node->name->name = self::NEW_NAME;
        }

        return null; // 返回null表示节点已经在上面逻辑中直接修改，不需要返回新节点
    }
}
