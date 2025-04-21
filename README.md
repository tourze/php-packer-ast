# PHP Packer AST

[![Latest Stable Version](https://poser.pugx.org/tourze/php-packer-ast/v/stable)](https://packagist.org/packages/tourze/php-packer-ast)
[![License](https://poser.pugx.org/tourze/php-packer-ast/license)](https://packagist.org/packages/tourze/php-packer-ast)
[![Build Status](https://github.com/tourze/php-monorepo/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/tourze/php-monorepo)

## Introduction

**PHP Packer AST** is a library for parsing, managing, and traversing PHP Abstract Syntax Trees (AST). It provides a simple and extensible API to parse PHP code, manage ASTs, and traverse nodes using the visitor pattern.

## Features

- Parse PHP code and files into AST
- Efficient AST manager for multiple files
- Visitor pattern support for flexible AST traversal
- Simple error handling mechanism
- Compatible with PHP 8.1 and above

## Installation

Require via Composer:

```bash
composer require tourze/php-packer-ast
```

## Quick Start

### Parse PHP Code

```php
use PhpPacker\Ast\CodeParser;

$parser = new CodeParser();
$ast = $parser->parseCode('<?php echo "Hello World"; ?>');

// Or parse from file
$ast = $parser->parseFile('/path/to/your/file.php');
```

### Use AST Manager

```php
use PhpPacker\Ast\AstManager;
use Psr\Log\NullLogger;

$manager = new AstManager(new NullLogger());

// Add AST
$manager->addAst('/path/to/file.php', $ast);

// Get AST
$ast = $manager->getAst('/path/to/file.php');

// Check existence
if ($manager->hasAst('/path/to/file.php')) {
    // ...
}

// Get statistics
$fileCount = $manager->getFileCount();
$nodeCount = $manager->getTotalNodeCount();
```

### Use Visitor Pattern

```php
use PhpPacker\Ast\Visitor\RenameDebugInfoVisitor;
use PhpParser\NodeTraverser;

$traverser = new NodeTraverser();
$traverser->addVisitor(new RenameDebugInfoVisitor());
$modifiedAst = $traverser->traverse($ast);
```

## Documentation

- API documentation: See source code and [tests](./tests)
- Configuration: No additional configuration required
- Advanced: Implement custom visitors by extending `AbstractVisitor`

## Contribution Guide

1. Fork and clone this repository
2. Create a new branch for your feature or bugfix
3. Write code and add tests
4. Run tests with PHPUnit
5. Submit a Pull Request

- Please follow PSR coding standards
- Ensure all tests pass before submitting

## License

MIT License. See [LICENSE](../../LICENSE) for details.

## Authors

- tourze Team

## Changelog

See [CHANGELOG](../../CHANGELOG.md) for release notes and upgrade guide.
