# 常见问题

## 同时安装了`swow` 和 `swoole`

```bash
Coroutine module is incompatible with some extensions that setup exit user opcode handler in Unknown on line 0
```

不能与不兼容的扩展同时加载，需要在 `php.ini` 中移除存在冲突的扩展。

## 使用SDB调试时提示 Please re-run your program with "-e" option

```bash
> attach 3 // 进入id为3的协程进行跟踪调试的命令
Error: Please re-run your program with "-e" option in path/to/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php:0
```

报错释义：需要在运行的时候加上`-e`参数，如`php -e xxx.php`。
原因：开启`-e`参数后，PHP会在执行每个OPCode时尝试调用扩展注册的回调函数，因此平时开启`-e`选项会影响程序性能，我们需要在调试的时候手动开启该选项，否则单步调试跟踪和断点功能将无法使用。
