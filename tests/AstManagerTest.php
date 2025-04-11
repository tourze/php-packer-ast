<?php

namespace PhpPacker\Ast\Tests;

use PhpPacker\Ast\AstManager;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AstManagerTest extends TestCase
{
    private AstManager $astManager;

    protected function setUp(): void
    {
        // 创建模拟日志记录器
        /** @var LoggerInterface $logger */
        $logger = $this->createMock(LoggerInterface::class);
        $this->astManager = new AstManager($logger);
    }

    public function testAddAndGetAst(): void
    {
        $file = '/tmp/test.php';
        $ast = [['type' => 'test']];

        // 添加AST
        $this->astManager->addAst($file, $ast);

        // 验证能否获取到
        $this->assertSame($ast, $this->astManager->getAst($file));
        $this->assertTrue($this->astManager->hasAst($file));
    }

    public function testGetNonExistentAst(): void
    {
        $this->assertNull($this->astManager->getAst('/non/existent/file.php'));
        $this->assertFalse($this->astManager->hasAst('/non/existent/file.php'));
    }

    public function testGetAllAsts(): void
    {
        $file1 = '/tmp/test1.php';
        $ast1 = [['type' => 'test1']];
        $file2 = '/tmp/test2.php';
        $ast2 = [['type' => 'test2']];

        $this->astManager->addAst($file1, $ast1);
        $this->astManager->addAst($file2, $ast2);

        $expected = [
            $file1 => $ast1,
            $file2 => $ast2,
        ];

        $this->assertEquals($expected, $this->astManager->getAllAsts());
    }

    public function testGetFileCount(): void
    {
        $this->assertEquals(0, $this->astManager->getFileCount());

        $this->astManager->addAst('/tmp/test1.php', []);
        $this->assertEquals(1, $this->astManager->getFileCount());

        $this->astManager->addAst('/tmp/test2.php', []);
        $this->assertEquals(2, $this->astManager->getFileCount());
    }

    public function testGetTotalNodeCount(): void
    {
        $this->assertEquals(0, $this->astManager->getTotalNodeCount());

        $this->astManager->addAst('/tmp/test1.php', [1, 2, 3]);
        $this->assertEquals(3, $this->astManager->getTotalNodeCount());

        $this->astManager->addAst('/tmp/test2.php', [4, 5]);
        $this->assertEquals(5, $this->astManager->getTotalNodeCount());
    }

    public function testClear(): void
    {
        $this->astManager->addAst('/tmp/test1.php', [1, 2, 3]);
        $this->astManager->addAst('/tmp/test2.php', [4, 5]);

        $this->assertEquals(2, $this->astManager->getFileCount());

        $this->astManager->clear();

        $this->assertEquals(0, $this->astManager->getFileCount());
        $this->assertEquals(0, $this->astManager->getTotalNodeCount());
        $this->assertEmpty($this->astManager->getAllAsts());
    }

    public function testCreateNodeTraverser(): void
    {
        $traverser = $this->astManager->createNodeTraverser();
        $this->assertNotNull($traverser);
    }
}
