<?php

namespace PhpPacker\Ast;

/**
 * 代码解析器接口
 */
interface CodeParserInterface
{
    /**
     * 解析文件
     *
     * @param string $file 文件路径
     * @return array 解析后的AST
     */
    public function parseFile(string $file): array;

    /**
     * 解析PHP代码字符串
     *
     * @param string $code PHP代码
     * @param string $identifier 用于标识此代码的名称（用于日志等）
     * @return array 解析后的AST
     */
    public function parseCode(string $code, string $identifier = 'inline-code'): array;

    /**
     * 获取AST管理器
     *
     * @return AstManagerInterface AST管理器实例
     */
    public function getAstManager(): AstManagerInterface;
}
