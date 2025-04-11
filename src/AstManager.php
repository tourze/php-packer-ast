<?php

namespace PhpPacker\Ast;

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * AST管理器实现
 */
class AstManager implements AstManagerInterface
{
    /**
     * AST映射表 [文件路径 => AST数组]
     */
    private array $astMap = [];

    /**
     * 日志记录器
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface|null $logger 日志记录器，默认为空日志记录器
     */
    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new NullLogger();
    }

    public function addAst(string $file, array $ast): void
    {
        $this->astMap[$file] = $ast;
        $this->logger->debug('Added AST for file', [
            'file' => $file,
            'nodes' => count($ast)
        ]);
    }

    public function getAst(string $file): ?array
    {
        return $this->astMap[$file] ?? null;
    }

    public function hasAst(string $file): bool
    {
        return isset($this->astMap[$file]);
    }

    public function getAllAsts(): array
    {
        return $this->astMap;
    }

    public function getFileCount(): int
    {
        return count($this->astMap);
    }

    public function getTotalNodeCount(): int
    {
        $count = 0;
        foreach ($this->astMap as $ast) {
            $count += count($ast);
        }
        return $count;
    }

    public function clear(): void
    {
        $this->astMap = [];
        $this->logger->debug('Cleared all ASTs');
    }

    public function createNodeTraverser(): NodeTraverser
    {
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NameResolver()); // 将所有名称解析为完全限定名称（FQCN）
        return $traverser;
    }
}
