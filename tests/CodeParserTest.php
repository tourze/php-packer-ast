<?php

namespace PhpPacker\Ast\Tests;

use PhpPacker\Ast\AstManager;
use PhpPacker\Ast\CodeParser;
use PhpPacker\Ast\Exception\ParseException;
use PhpPacker\Ast\ParserFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class CodeParserTest extends TestCase
{
    private CodeParser $codeParser;

    protected function setUp(): void
    {
        $astManager = new AstManager(new NullLogger());
        $parser = ParserFactory::createPhp81Parser();
        $logger = new NullLogger();

        $this->codeParser = new CodeParser($astManager, $parser, $logger);
    }

    public function testParseCodeSuccess(): void
    {
        $code = '<?php echo "Hello World"; ?>';
        $identifier = 'test.php';

        $result = $this->codeParser->parseCode($code, $identifier);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testParseCodeWithParseError(): void
    {
        $code = '<?php echo "Missing quote; ?>';
        $identifier = 'invalid.php';

        $this->expectException(ParseException::class);
        $this->codeParser->parseCode($code, $identifier);
    }

    public function testParseFileSuccess(): void
    {
        // 创建临时测试文件
        $tempFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tempFile, '<?php echo "Test"; ?>');

        try {
            $result = $this->codeParser->parseFile($tempFile);
            $this->assertIsArray($result);
            $this->assertNotEmpty($result);

            // 检查AST是否已添加到管理器
            $this->assertTrue($this->codeParser->getAstManager()->hasAst($tempFile));
        } finally {
            // 清理
            @unlink($tempFile);
        }
    }

    public function testParseFileNotFound(): void
    {
        $nonExistentFile = '/non/existent/file.php';

        $this->expectException(ParseException::class);
        $this->expectExceptionMessage("File not found: $nonExistentFile");

        $this->codeParser->parseFile($nonExistentFile);
    }

    public function testGetAstManager(): void
    {
        $this->assertNotNull($this->codeParser->getAstManager());
    }
}
