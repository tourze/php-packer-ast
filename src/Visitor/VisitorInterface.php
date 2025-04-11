<?php

namespace PhpPacker\Ast\Visitor;

use PhpParser\NodeVisitor;

/**
 * AST访问者接口
 */
interface VisitorInterface extends NodeVisitor
{
    /**
     * 获取访问者名称
     *
     * @return string 访问者名称
     */
    public function getName(): string;
}
