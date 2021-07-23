# 协程API

## 方法

### run()

创建一个新的协程，立即执行，并返回当前协程对象

```php
Swow\Coroutine::run(callable $function, ...$data): self
$coroutine = Swow\Coroutine::run(function (...$data) {
    echo implode('', $data) . PHP_LF;
}, 'I', 'n');
//output 
//In
```

* 参数
  + `callable $function`
    * 功能： 协程执行的代码,必须为callable
    * 默认值：无
    * 其他值：无
  + `...$data`
    * 功能：传入的参数
    * 默认值：无
    * 其他值：无
* 返回值
  + 创建成功返回当前协程对象

* 与swoole差异  
  + swoole返回的值是协程ID
    
### resume()

恢复被挂起的协程，并接收当前返回值

```php
$coroutine = Coroutine::run(function ($a) {
    $b = Coroutine::yield();
    return $a . ' ' . $b;
}, 'hello');
echo $coroutine->resume('world') . ' #' .PHP_EOL;
//output
//hello world #
```
* 参数
  + `...$data`
    * 功能：传入的参数
    * 默认值：无
    * 其他值：无
* 返回值
  + 根据协程里的返回内容而定(mixed)

* 与swoole差异  
  + swoole没有返回值
