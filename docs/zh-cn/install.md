
Swow 扩展安装提供了以下几种方法

## 编译安装 (UNIX-like 或 cygwin、msys、wsl)

下载或者 clone 源代码后，在终端进入源码目录，执行下面的命令进行编译和安装

```shell
git clone https://github.com/swow/swow.git swow

cd swow/ext
phpize
./configure
make
sudo make install
```

## 编译安装 (Windows)

### 准备MSVC

根据你所使用的PHP发布选择安装MSVC的版本，例如使用了PHP 8.0.1的"VS16 x64 Non Thread Safe"选项，则需要选择VS16，也就是VS2019

| VC版本号 | VS版本 | 说明 |
| - | - | - |
| VS16 | 2019 |  |
| VC15 | 2017 | 安装VS2017或者在安装VS2019时选择VS2017工具链 |
| VC14 | 2015 | 安装VS2015或者在安装VS2017时选择VS2015工具链 |

### 准备devpack

在 [PHP Windows 下载页](https://windows.php.net/download/) 找到你所使用PHP版本的"Development package (SDK to develop PHP extensions)"链接，下载它

解压到任意目录（以下使用C:\php-8.0.1-devel-vs16-x64为例）

### 准备php-sdk-binary-tools

clone微软提供的php-sdk-binary-tools到任意目录（以下使用C:\php-sdk-binary-tools为例）

```batch
git clone https://github.com/Microsoft/php-sdk-binary-tools
```

### 准备依赖
!>  目前Swow未实现openssl（20210128），因此不需要准备任何依赖

在 `https://windows.php.net/downloads/php-sdk/deps/<vc版本例如vc15或者vs16>/<架构名例如x64>/` 找到依赖的包（例如openssl）

解压到任意目录（以下使用C:\deps为例）

如果解压到swow扩展源码目录的同级deps目录，则下面可以省去--with-php-build参数

例如 swow源码在C:\swow， deps在C\swow\deps时

### 构建

打开PHP工具命令行：

例如在为之前提到的PHP8.0 VS16 x64 NTS构建swow扩展则执行C:\php-sdk-binary-tools\phpsdk-vs16-x64.bat 

在打开的命令行中下载或者 clone 源代码后，进入源码目录，执行下面的命令进行构建

```batch
git clone https://github.com/swow/swow.git swow
CD swow\ext
REM 下面的C:\php-8.0.1-devel-vs16-x64是之前解压的devpack路径
C:\php-8.0.1-devel-vs16-x64\phpize.bat
configure.bat --enable-swow --with-php-build=C:\deps
nmake
```

构建完成后，将生成的php_swow.dll放置于extension_dir中（默认的，这个目录是php文件同级的ext目录或者C:\php\ext，具体情况参照所使用的PHP发行说明）

!> 编译成功后，在使用时推荐通过 `-d` 来按需加载 Swow 扩展，如：`php -d extension=swow`

## Composer

可以使用 Composer 下载源码

```shell
composer require swow/swow:dev-develop
```

下载完成后在 `vendor/bin` 目录中会有一个 `swow-builder` 的文件，我们可以使用此脚本文件来安装扩展

此脚本提供了4个参数，分别为`rebuild`, `show-log`, `debug`, `enable`，支持同时多个参数，示例如下

```shell
#编译扩展
php vendor/bin/swow-builder

#重新编译扩展
php vendor/bin/swow-builder --rebuild

#编译扩展时显示完整编译日志信息
php vendor/bin/swow-builder --show-log

#编译扩展并打开扩展的调试模式
php vendor/bin/swow-builder --debug

#编译扩展时增加一些编译参数
php vendor/bin/swow-builder --enable="--enable-debug"
```

!> 编译成功后，在使用时推荐通过 `-d` 来按需加载 Swow 扩展，如：`php -d extension=swow`

## 编译参数

* `--enable-debug`

打开（PHP的）调试模式


* `--enable-swow-debug`

打开Swow调试


* `--enable-swow`

开启Swow扩展的编译
