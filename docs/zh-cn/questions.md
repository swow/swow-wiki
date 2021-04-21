# 常见问题

## 同时安装了`swow` 和 `swoole`

```
Coroutine module is incompatible with some extensions that setup exit user opcode handler in Unknown on line 0
```
您需要在您的 php.ini 配置文件注释掉 `extension=swoole.so` 配置项.
不能与不兼容的扩展同时开启，ini中关闭可能冲突的扩展。

