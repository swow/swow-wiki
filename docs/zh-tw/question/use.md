# 常見問題

## 同時安裝了`swow` 和 `swoole`

```
Coroutine module is incompatible with some extensions that setup exit user opcode handler in Unknown on line 0
```

!> 不能與不相容的擴充套件同時載入，需要在 `php.ini` 中移除存在衝突的擴充套件。

## 使用SDB除錯時提示 Please re-run your program with "-e" option

```
# 進入id為3的協程進行跟蹤除錯
> attach 3
Error: Please re-run your program with "-e" option in path/to/vendor/swow/swow/lib/src/Swow/Debug/Debugger.php:0
```

!> 需要在執行的時候加上`-e`引數，如`php -e your_file.php`。

?> 原因：開啟`-e`引數後，PHP會在執行每個OPCode時嘗試呼叫擴充套件註冊的回撥函式，因此平時開啟`-e`選項會影響程式效能，我們需要在除錯的時候手動開啟該選項，否則單步除錯跟蹤和斷點功能將無法使用。
