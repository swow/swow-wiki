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

### yield()

手动让出当前的协程执行权(被挂起),一般配合resume使用

```php
$coroutine = Coroutine::run(function ($a) {
    $b = Coroutine::yield();//world
    return $a . ' ' . $b;
}, 'hello');
echo $coroutine->resume('world') . ' #' .PHP_EOL;
//output
//hello world #
```

* 参数
    + `$data`
        * 功能：传入的参数
        * 默认值： 无
        * 其他值：无
* 返回值
    + 通过resume($data)传入的参数
* 与swoole差异
    + swoole没有返回值

### getId()

获取当前协程的唯一`ID`

* 返回值
    + 返回当前协程ID

### getCurrent()

静态方法获取当前协程对象

```php
\Swow\Coroutine::getCurrent();

//output
//object(Swow\Coroutine)#0 (5) {
//  ["id"]=>
//  int(1)
//  ["state"]=>
//  string(7) "running"
//  ["round"]=>
//  int(3)
//  ["elapsed"]=>
//  string(4) "16ms"
//  ["trace"]=>
//  string(156) "
//#0 [internal function]: Swow\Coroutine->__debugInfo()
//#1 /Users/heping/Serendipity-Job/tests/coroutine.php(10): var_dump(Object(Swow\Coroutine))
//#2 {main}
//"
//}

```

* 返回值
    + 返回当前协程对象

### getMain()

获取主协程，返回主协程对象

```php
var_dump(Coroutine::getMain());
//output 
//
//object(Swow\Coroutine)#0 (5) {
//  ["id"]=>
//  int(1)
//  ["state"]=>
//  string(7) "running"
//  ["round"]=>
//  int(3)
//  ["elapsed"]=>
//  string(3) "2ms"
//  ["trace"]=>
//  string(115) "
//#0 /Users/heping/Serendipity-Job/tests/coroutine.php(45): Swow\Coroutine::run(Object(Closure), 'hello')
//#1 {main}
//"
}
```

* 返回值
    + 返回主协程对象

### getPrevious()

获取上一层协程，类似于获取父协程，返回上一层协程对象

```php
$coroutine = Coroutine::run(function ($a) {
    var_dump(Coroutine::getMain());
    Coroutine::run(function (){
        var_dump(Coroutine::getCurrent()->getPrevious());
        //output
//  object(Swow\Coroutine)#2 (5) {
//  ["id"]=>
//  int(2)
//  ["state"]=>
//  string(7) "running"
//  ["round"]=>
//  int(4)
//  ["elapsed"]=>
//  string(3) "2ms"
//  ["trace"]=>
//  string(149) "
//#0 /Users/heping/Serendipity-Job/tests/coroutine.php(42): Swow\Coroutine::run(Object(Closure))
//#1 [internal function]: {closure}('hello')
//#2 {main}
//"
//}
    });
    $b = Coroutine::yield();
    return $a . ' ' . $b;
}, 'hello');
echo $coroutine->resume('world') . ' #' . PHP_EOL;

```

* 返回值
    + 返回上一层(父)协程对象

### getState()

获取协程当前执行状态，返回状态数值，可以用getStateName()获取状态信息

```php
$coroutine = Coroutine::run(function ($a) {
//    var_dump(Coroutine::getMain());
//    Coroutine::run(function (){
//        var_dump(Coroutine::getCurrent()->getPrevious());
//    });
    $b = Coroutine::yield();
    return $a . ' ' . $b;
}, 'hello');
var_dump($coroutine->getState());//output 3 waiting

```

* 返回值
    + 返回状态数值int类型，状态信息可以用getStateName()获取。

### getStateName()

获取协程当前执行状态信息

```php
$coroutine = Coroutine::run(function ($a) {
//    var_dump(Coroutine::getMain());
//    Coroutine::run(function (){
//        var_dump(Coroutine::getCurrent()->getPrevious());
//    });
    $b = Coroutine::yield();
    return $a . ' ' . $b;
}, 'hello');
var_dump($coroutine->getStateName());//output  string(7) "waiting"

```

* 作用
    + 可以判断协程是否在运行状态,检测死锁

* 返回值
    + 返回string类型的状态值

### getRound()

获取协程切换次数

```php
 Coroutine::getCurrent()->getRound(); //output 1
```

* 作用
    + 协程最后一次调度是在第几轮,每切换一次全局轮数+1

* 返回值
    + 返回int类型

### getElapsed()

获取协程运行的时间以便于分析统计或找出僵尸协程

```php
 Coroutine::getCurrent()->getElapsed(); //output 600ms
```

* 返回值
    + 协程已运行的时间数，毫秒级精度
