# 常见问题

## 同时安装了`swow` 和 `swoole`

```bash
Coroutine module is incompatible with some extensions that setup exit user opcode handler in Unknown on line 0
```

不能与不兼容的扩展同时加载，需要在 `php.ini` 中移除存在冲突的扩展。
