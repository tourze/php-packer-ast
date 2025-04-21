# PHP Packer AST

[![最新稳定版本](https://poser.pugx.org/tourze/php-packer-ast/v/stable)](https://packagist.org/packages/tourze/php-packer-ast)
[![许可证](https://poser.pugx.org/tourze/php-packer-ast/license)](https://packagist.org/packages/tourze/php-packer-ast)
[![构建状态](https://github.com/tourze/php-monorepo/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/tourze/php-monorepo)

## 项目简介

**PHP Packer AST** 是一个用于解析、管理和遍历 PHP 抽象语法树（AST）的工具库。它提供了简单且可扩展的 API，可用于解析 PHP 代码、集中管理 AST、并通过访问者模式灵活遍历节点。

## 功能特性

- 支持将 PHP 代码和文件解析为 AST
- 高效的多文件 AST 管理器
- 支持访问者模式，灵活遍历和处理 AST
- 简单明了的错误处理机制
- 兼容 PHP 8.1 及以上版本

## 安装说明

通过 Composer 安装：

```bash
composer require tourze/php-packer-ast
```

## 快速开始

### 解析 PHP 代码

```php
use PhpPacker\Ast\CodeParser;

$parser = new CodeParser();
$ast = $parser->parseCode('<?php echo "Hello World"; ?>');

// 或从文件解析
$ast = $parser->parseFile('/path/to/your/file.php');
```

### 使用 AST 管理器

```php
use PhpPacker\Ast\AstManager;
use Psr\Log\NullLogger;

$manager = new AstManager(new NullLogger());

// 添加 AST
$manager->addAst('/path/to/file.php', $ast);

// 获取 AST
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
use PhpPacker\Ast\Visitor\RenameDebugInfoVisitor;
use PhpParser\NodeTraverser;

$traverser = new NodeTraverser();
$traverser->addVisitor(new RenameDebugInfoVisitor());
$modifiedAst = $traverser->traverse($ast);
```

## 详细文档

- API 文档：请参考源码和 [测试用例](./tests)
- 配置说明：无需额外配置
- 高级用法：可继承 `AbstractVisitor` 实现自定义访问者

## 贡献指南

1. Fork 并克隆本仓库
2. 新建分支开发新特性或修复问题
3. 编写代码并补充测试
4. 使用 PHPUnit 运行测试
5. 提交 Pull Request

- 请遵循 PSR 代码规范
- 提交前请确保所有测试均通过

## 版权和许可

MIT 协议，详见 [LICENSE](../../LICENSE)

## 作者信息

- tourze 团队

## 更新日志

详见 [CHANGELOG](../../CHANGELOG.md) 获取版本更新记录和升级指南。
