# 常见问题

## 同时安装了`swow` 和 `swoole`

```bash
Coroutine module is incompatible with some extensions that setup exit user opcode handler in Unknown on line 0
```

不能与不兼容的扩展同时加载，需要在 `php.ini` 中移除存在冲突的扩展。

## Swow开启调试模式后,提示 Please re-run your program with "-e" option

```text
> attach 3 //进入协程id为3的命令
Error: Please re-run your program with "-e" option in YourProject/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php:831
```

需要在启动Swow的时候加上`php -e xx xxjob`的选项.
