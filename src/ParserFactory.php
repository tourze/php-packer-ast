<?php

namespace PhpPacker\Ast;

use PhpParser\Parser;
use PhpParser\ParserFactory as BaseParserFactory;
use PhpParser\PhpVersion;

/**
 * AST解析器工厂
 */
class ParserFactory
{
    /**
     * 创建PHP解析器
     *
     * @param string $phpVersion PHP版本，如'8.1'
     * @return Parser 解析器实例
     */
    public static function create(string $phpVersion = '8.1'): Parser
    {
        return (new BaseParserFactory)->createForVersion(
            PhpVersion::fromString($phpVersion)
        );
    }

    /**
     * 创建针对PHP 8.1的解析器
     *
     * @return Parser 解析器实例
     */
    public static function createPhp81Parser(): Parser
    {
        return self::create('8.1');
    }

    /**
     * 创建针对PHP 8.2的解析器
     *
     * @return Parser 解析器实例
     */
    public static function createPhp82Parser(): Parser
    {
        return self::create('8.2');
    }

    /**
     * 创建针对PHP 8.3的解析器
     *
     * @return Parser 解析器实例
     */
    public static function createPhp83Parser(): Parser
    {
        return self::create('8.3');
    }
}
