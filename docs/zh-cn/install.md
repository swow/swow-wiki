# 扩展安装

Swow 扩展安装提供了以下几种方法

## 编译安装 (UNIX-like 或 cygwin、msys、wsl)

首先安装PHP，安装方法参考各发行版说明

### 准备构建依赖（UNIX）

如果你需要cURL hook支持或者ssl支持

#### linux

```bash
# debian and its varient like ubuntu, kali, armbian, raspbian, deepin, uos
apt-get install libcurl4-openssl-dev libssl-dev
# fedora, rhel 8, centos 8
dnf install libcurl-devel openssl-devel
# legacy fedora, rhel 6/7, centos 6/7
yum install libcurl-devel openssl-devel
# archlinux and its varient like archlinuxarm, blackarch
pacman -S curl openssl
# alpine
apk add curl-dev openssl-dev
# opensuse, suse
zypper install libcurl-devel libopenssl-devel
```

#### macOS

```bash
brew install curl openssl
```

然后根据提示export PKG_CONFIG_PATH来让configure

### 构建安装

下载或者 clone 源代码后，在终端进入源码目录，执行下面的命令进行编译和安装，构建参数见[下面的说明](#%E7%BC%96%E8%AF%91%E5%8F%82%E6%95%B0)

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

### 准备构建依赖（Windows）

在 `https://windows.php.net/downloads/php-sdk/deps/<vc版本例如vc15或者vs16>/<架构名例如x64>/` 找到依赖的包（例如curl）

注意版本对齐，未对齐的依赖版本可能导致奇怪的segfault，PHP无法正常退出等神奇问题，`https://windows.php.net/downloads/php-sdk/deps/series/`中的文件提供了这些版本信息

解压到任意目录（以下使用C:\deps为例）

如果解压到Swow扩展源码目录的同级deps目录，则下面可以省去--with-php-build参数

例如Swow源码在C:\swow，Swow扩展源码目录在C:\swow\ext，deps在C:\swow\deps时

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

### 支持参数

* `--enable-swow`

开启Swow扩展的编译（默认开启，可以指定`=yes`或者`=shared`，`=static`）

* `--enable-swow-ssl`

开启Swow SSL支持，需要OpenSSL

* `--enable-swow-curl`

开启Swow cURL支持，需要cURL

### 调试参数

* `--enable-debug`

打开PHP的调试模式，需要在**编译PHP时**指定，在编译Swow时指定无效

* （Windows）`--enable-debug-pack`

打开扩展的的debug pack构建，用于Windows下Release版本PHP的Swow调试，**编译Swow时**指定，不能与`--enable-debug`一同使用

* `--enable-swow-debug`

打开Swow的调试模式

* （Linux）`--enable-swow-valgrind`

（需要`--enable-swow-debug`）打开Swow的valgrind支持，用于检查C代码内存问题

* （Unix-like）`--enable-swow-gcov`

（需要`--enable-swow-debug`）开启Swow的GCOV支持，用于C代码覆盖率支持

* （Unix-like）`--enable-swow-{address,undefined,memory}-sanitizer`

（需要`--enable-swow-debug`）开启Swow的{A,UB,M}San支持，用于找出C代码的潜在问题
