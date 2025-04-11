<?php

namespace PhpPacker\Ast;

use PhpParser\NodeTraverser;

/**
 * AST管理器接口
 */
interface AstManagerInterface
{
    /**
     * 添加AST到管理器
     *
     * @param string $file 文件路径
     * @param array $ast 抽象语法树节点数组
     */
    public function addAst(string $file, array $ast): void;

    /**
     * 获取指定文件的AST
     *
     * @param string $file 文件路径
     * @return array|null 文件对应的AST数组，如果不存在则返回null
     */
    public function getAst(string $file): ?array;

    /**
     * 检查是否存在指定文件的AST
     *
     * @param string $file 文件路径
     * @return bool 是否存在
     */
    public function hasAst(string $file): bool;

    /**
     * 获取所有已解析的AST
     *
     * @return array [文件路径 => AST数组] 的关联数组
     */
    public function getAllAsts(): array;

    /**
     * 获取已解析的文件数量
     *
     * @return int 文件数量
     */
    public function getFileCount(): int;

    /**
     * 获取所有AST节点的总数
     *
     * @return int 节点总数
     */
    public function getTotalNodeCount(): int;

    /**
     * 清空所有已解析的AST
     */
    public function clear(): void;

    /**
     * 创建一个标准配置的节点遍历器
     *
     * @return NodeTraverser 节点遍历器
     */
    public function createNodeTraverser(): NodeTraverser;
}
