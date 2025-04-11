<?php

namespace PhpPacker\Ast;

use PhpPacker\Ast\Exception\ParseException;
use PhpParser\Error;
use PhpParser\Parser;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * 代码解析器实现
 */
class CodeParser implements CodeParserInterface
{
    /**
     * AST管理器
     */
    private AstManagerInterface $astManager;

    /**
     * PHP解析器
     */
    private Parser $parser;

    /**
     * 日志记录器
     */
    private LoggerInterface $logger;

    /**
     * @param AstManagerInterface|null $astManager AST管理器，不提供则创建默认实例
     * @param Parser|null $parser PHP解析器，不提供则创建默认实例
     * @param LoggerInterface|null $logger 日志记录器，不提供则使用空记录器
     */
    public function __construct(
        ?AstManagerInterface $astManager = null,
        ?Parser $parser = null,
        ?LoggerInterface $logger = null
    )
    {
        $this->astManager = $astManager ?? new AstManager($logger);
        $this->parser = $parser ?? ParserFactory::createPhp81Parser();
        $this->logger = $logger ?? new NullLogger();
    }

    public function parseFile(string $file): array
    {
        if (!file_exists($file)) {
            $this->logger->error('File not found', ['file' => $file]);
            throw new ParseException("File not found: $file");
        }

        $code = @file_get_contents($file);
        if ($code === false) {
            $this->logger->error('Could not read file', ['file' => $file]);
            throw new ParseException("Could not read file: $file");
        }

        $ast = $this->parseCode($code, $file);
        $this->astManager->addAst($file, $ast);

        return $ast;
    }

    public function parseCode(string $code, string $identifier = 'inline-code'): array
    {
        try {
            $ast = $this->parser->parse($code);

            if (!is_array($ast)) {
                $this->logger->error('Parse error: Invalid AST', ['identifier' => $identifier]);
                throw new ParseException("Invalid AST returned for: $identifier");
            }

            $this->logger->debug('Code parsed successfully', [
                'identifier' => $identifier,
                'nodes' => count($ast)
            ]);

            return $ast;
        } catch (Error $e) {
            $this->logger->error('Parse error', [
                'identifier' => $identifier,
                'message' => $e->getMessage(),
                'line' => $e->getStartLine()
            ]);

            throw new ParseException(
                "Parse error in $identifier: " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    public function getAstManager(): AstManagerInterface
    {
        return $this->astManager;
    }
}
