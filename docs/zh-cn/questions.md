# 常见问题

## 同时安装了`swow` 和 `swoole`

```
Coroutine module is incompatible with some extensions that setup exit user opcode handler in Unknown on line 0
```
您需要在您的 php.ini 配置文件注释掉 `extension=swoole.so` 配置项.
不能与不兼容的扩展同时开启，ini中关闭可能冲突的扩展。

## 使用`SDB`进行调试

```
PHP Fatal error:  Uncaught Swow\Socket\Exception: Socket has not been established in /swow/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php:126
Stack trace:
#0 /swow/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php(126): Swow\Socket->recvString()
#1 /swow/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php(920): Swow\Debug\Debugger->in()
#2 /swow/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php(1153): Swow\Debug\Debugger->run('sdb')
#3 /swow/vendor/swow/swow/examples/debug/debugger/demo.php(20): Swow\Debug\Debugger::runOnTTY()
#4 {main}
  thrown in /swow/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php on line 126
```
