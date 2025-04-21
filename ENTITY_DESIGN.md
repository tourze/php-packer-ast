# PHP Packer AST 模块实体设计说明

本模块主要涉及以下核心实体：

## 1. AstManager
- 负责集中管理所有解析得到的 AST。
- 以文件路径为 key 存储对应 AST 数组。
- 提供添加、获取、判断、统计、清空等管理方法。

## 2. CodeParser
- 负责解析 PHP 代码或文件，生成 AST。
- 支持直接解析字符串代码或文件内容。
- 解析失败时抛出 ParseException 异常。
- 解析成功后将 AST 注册到 AstManager。

## 3. Visitor (访问者)
- 实现访问者模式，遍历和处理 AST 节点。
- 通过 NodeTraverser 配合使用，可灵活扩展。
- 包括 AbstractVisitor、RenameDebugInfoVisitor 等实现。

## 4. ParseException
- 解析出错时抛出的异常类型。

---

## 设计说明
- 本模块采用面向接口编程，方便扩展和替换。
- AST 存储为数组，便于序列化和统计。
- 访问者模式使 AST 处理逻辑高度解耦，可按需扩展。
- 日志接口支持灵活注入，便于调试和生产环境适配。

> 该设计有助于在大型项目或工具链中高效集成和管理 PHP AST。
