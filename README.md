# PHP Packer AST

PHP Packer AST 是一个用于处理和管理PHP抽象语法树（AST）的工具库。它提供了简单易用的API来解析PHP代码、操作AST和使用访问者模式遍历语法树。

## 特性

- 代码解析和AST管理
- 高效的节点遍历器
- 通用访问者模式实现
- 简单的错误处理机制
- 兼容PHP 8.1及以上版本

## 安装

使用Composer安装：

```bash
composer require tourze/php-packer-ast
```

## 基本用法

### 解析PHP代码

```php
use PhpPacker\Ast\CodeParser;

$parser = new CodeParser();
$ast = $parser->parseCode('<?php echo "Hello World"; ?>');

// 或者解析文件
$ast = $parser->parseFile('/path/to/your/file.php');
```

### 使用AST管理器

```php
use PhpPacker\Ast\AstManager;
use Psr\Log\NullLogger;

$manager = new AstManager(new NullLogger());

// 添加AST
$manager->addAst('/path/to/file.php', $ast);

// 获取AST
$ast = $manager->getAst('/path/to/file.php');

// 检查是否存在
if ($manager->hasAst('/path/to/file.php')) {
    // ...
}

// 获取统计信息
$fileCount = $manager->getFileCount();
$nodeCount = $manager->getTotalNodeCount();
```

### 使用访问者模式

```php
use PhpPacker\Ast\AstManager;
use PhpPacker\Ast\Visitor\RenameDebugInfoVisitor;

$manager = new AstManager();
$traverser = $manager->createNodeTraverser();

// 添加自定义访问者
$traverser->addVisitor(new RenameDebugInfoVisitor());

// 遍历AST
$newAst = $traverser->traverse($ast);
```

### 创建自定义访问者

```php
use PhpPacker\Ast\Visitor\AbstractVisitor;
use PhpParser\Node;

class MyCustomVisitor extends AbstractVisitor
{
    public function leaveNode(Node $node)
    {
        // 实现访问者逻辑
        if ($node instanceof Node\Scalar\String_) {
            $node->value = strtoupper($node->value);
        }
        
        return null; // 返回null表示不替换节点，直接修改当前节点
    }
}
```

## 高级用法

### 使用解析器工厂

```php
use PhpPacker\Ast\ParserFactory;

// 创建指定PHP版本的解析器
$parser81 = ParserFactory::createPhp81Parser();
$parser82 = ParserFactory::createPhp82Parser();
$parser83 = ParserFactory::createPhp83Parser();

// 或自定义版本
$parser = ParserFactory::create('8.1');
```

## 单元测试

运行单元测试：

```bash
composer install
vendor/bin/phpunit
```

## 许可证

MIT

## 鸣谢

- [nikic/php-parser](https://github.com/nikic/PHP-Parser) - PHP解析器库 