# 常見問題

## 同時安裝了`swow` 和 `swoole`

```
Coroutine module is incompatible with some extensions that setup exit user opcode handler in Unknown on line 0
```

!> 不能與不兼容的擴展同時加載，需要在 `php.ini` 中移除存在衝突的擴展。

## 使用SDB調試時提示 Please re-run your program with "-e" option

```
# 進入id為3的協程進行跟蹤調試
> attach 3
Error: Please re-run your program with "-e" option in path/to/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php:0
```

!> 需要在運行的時候加上`-e`參數，如`php -e your_file.php`。

?> 原因：開啟`-e`參數後，PHP會在執行每個OPCode時嘗試調用擴展註冊的回調函數，因此平時開啟`-e`選項會影響程序性能，我們需要在調試的時候手動開啟該選項，否則單步調試跟蹤和斷點功能將無法使用。
