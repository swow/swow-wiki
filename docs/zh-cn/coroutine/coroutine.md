# 协程API

## 方法

### run(callable $callable, mixed ...$data)

创建一个新的协程，立即执行，并返回当前协程对象

* 参数

   * **`callable $callable`**
   * **功能**： 协程执行的代码,必须为callable
   * **默认值**：无
   * **其他值**：无
   * **`...$data`**
   * **功能**：传入的参数
   * **默认值**：无
   * **其他值**：无
   
* 返回值

   - 创建成功返回当前协程对象

* 示例

```php
$coroutine = Swow\Coroutine::run(function (...$data) {
    echo implode('', $data) . PHP_LF;
}, 'I', 'n');
//output 
//In
```

### resume(mixed ...$data)

恢复被挂起的协程，并接收当前返回值

* 参数
   * **`...$data`**
   * **功能**：传入的参数
   * **默认值**：无
   * **其他值**：无
    
* 返回值
  - 根据协程里的返回内容而定(mixed)
  
* 示例

```php
$coroutine = Coroutine::run(function ($a) {
    $b = Coroutine::yield();
    return $a . ' ' . $b;
}, 'hello');
echo $coroutine->resume('world') . ' #' .PHP_EOL;
//output
//hello world #
```

### yield(mixed $data = null)

手动让出当前的协程执行权(被挂起),一般配合resume使用

* 参数

  * **`$data`**
  * **功能**：传入的参数
  * **默认值**： 无
  * **其他值**：无
  
* 返回值

    - 通过resume($data)传入的参数

* 示例

```php
$coroutine = Coroutine::run(function ($a) {
    $b = Coroutine::yield();//world
    return $a . ' ' . $b;
}, 'hello');
echo $coroutine->resume('world') . ' #' .PHP_EOL;
//output
//hello world #
```

### getId()

获取当前协程的唯一`ID`

* 返回值

  - 返回当前协程ID
  
* 示例

```php
$coroutine = Coroutine::run(function ($a) {
    echo $a . ' ' . $b;
}, 'hello');
$coroutine->getId();
```

### getCurrent()

静态方法获取当前协程对象

* 返回值

    - 返回当前协程对象
    
* 示例  

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

### getMain()

获取主协程，返回主协程对象

* 返回值

   - 返回主协程对象

* 示例

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

### getPrevious()

获取上一层协程，类似于获取父协程，返回上一层协程对象

* 返回值

  - 返回上一层(父)协程对象

* 示例

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

### getState()

获取协程当前执行状态，返回状态数值，可以用getStateName()获取状态信息

* 返回值

   - 返回状态数值int类型，状态信息可以用getStateName()获取。
   
* 示例

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

### getStateName()

获取协程当前执行状态信息

* 作用

   - 可以判断协程是否在运行状态,检测死锁

* 返回值

    -  返回string类型的状态值

* 示例

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

### getRound()

获取协程切换次数

* 作用

    - 协程最后一次调度是在第几轮,每切换一次全局轮数+1

* 返回值

    - 返回int类型

* 示例

```php
 Coroutine::getCurrent()->getRound(); //output 1
```

### getElapsed()

获取协程运行的时间以便于分析统计或找出僵尸协程

* 返回值

    - 协程已运行的时间数，毫秒级精度

* 示例

```php
 Coroutine::getCurrent()->getElapsed(); //output 600ms
```
