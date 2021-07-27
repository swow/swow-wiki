# 擴充套件安裝

Swow 擴充套件安裝提供了以下幾種方法

## 編譯安裝 (UNIX-like 或 cygwin、msys、wsl)

下載或者 clone 原始碼後，在終端進入原始碼目錄，執行下面的命令進行編譯和安裝

```shell
git clone https://github.com/swow/swow.git swow

cd swow/ext
phpize
./configure
make
sudo make install
```

## 編譯安裝 (Windows)

### 準備MSVC

根據你所使用的PHP釋出選擇安裝MSVC的版本，例如使用了PHP 8.0.1的"VS16 x64 Non Thread Safe"選項，則需要選擇VS16，也就是VS2019

| VC版本號 | VS版本 | 說明 |
| - | - | - |
| VS16 | 2019 |  |
| VC15 | 2017 | 安裝VS2017或者在安裝VS2019時選擇VS2017工具鏈 |
| VC14 | 2015 | 安裝VS2015或者在安裝VS2017時選擇VS2015工具鏈 |

### 準備devpack

在 [PHP Windows 下載頁](https://windows.php.net/download/) 找到你所使用PHP版本的"Development package (SDK to develop PHP extensions)"連結，下載它

解壓到任意目錄（以下使用C:\php-8.0.1-devel-vs16-x64為例）

### 準備php-sdk-binary-tools

clone微軟提供的php-sdk-binary-tools到任意目錄（以下使用C:\php-sdk-binary-tools為例）

```batch
git clone https://github.com/Microsoft/php-sdk-binary-tools
```

### 準備依賴

!> 目前Swow未實現openssl（20210128），因此不需要準備任何依賴

在 `https://windows.php.net/downloads/php-sdk/deps/<vc版本例如vc15或者vs16>/<架構名例如x64>/` 找到依賴的包（例如openssl）

解壓到任意目錄（以下使用C:\deps為例）

如果解壓到Swow擴充套件原始碼目錄的同級deps目錄，則下面可以省去--with-php-build引數

例如Swow原始碼在C:\swow，deps在C:\swow\deps時

### 構建

開啟PHP工具命令列：

例如在為之前提到的PHP8.0 VS16 x64 NTS構建swow擴充套件則執行C:\php-sdk-binary-tools\phpsdk-vs16-x64.bat 

在開啟的命令列中下載或者 clone 原始碼後，進入原始碼目錄，執行下面的命令進行構建

```batch
git clone https://github.com/swow/swow.git swow
CD swow\ext
REM 下面的C:\php-8.0.1-devel-vs16-x64是之前解壓的devpack路徑
C:\php-8.0.1-devel-vs16-x64\phpize.bat
configure.bat --enable-swow --with-php-build=C:\deps
nmake
```

構建完成後，將生成的php_swow.dll放置於extension_dir中（預設的，這個目錄是php檔案同級的ext目錄或者C:\php\ext，具體情況參照所使用的PHP發行說明）

!> 編譯成功後，在使用時推薦通過 `-d` 來按需載入 Swow 擴充套件，如：`php -d extension=swow`

## Composer

可以使用 Composer 下載原始碼

```shell
composer require swow/swow:dev-develop
```

下載完成後在 `vendor/bin` 目錄中會有一個 `swow-builder` 的檔案，我們可以使用此指令碼檔案來安裝擴充套件

此指令碼提供了4個引數，分別為`rebuild`, `show-log`, `debug`, `enable`，支援同時多個引數，示例如下

```shell
#編譯擴充套件
php vendor/bin/swow-builder

#重新編譯擴充套件
php vendor/bin/swow-builder --rebuild

#編譯擴充套件時顯示完整編譯日誌資訊
php vendor/bin/swow-builder --show-log

#編譯擴充套件並開啟擴充套件的除錯模式
php vendor/bin/swow-builder --debug

#編譯擴充套件時增加一些編譯引數
php vendor/bin/swow-builder --enable="--enable-debug"
```

!> 編譯成功後，在使用時推薦通過 `-d` 來按需載入 Swow 擴充套件，如：`php -d extension=swow`

## 編譯引數

* `--enable-debug`

開啟PHP的除錯模式

* `--enable-swow-debug`

開啟Swow的除錯模式

* `--enable-swow`

開啟Swow擴充套件的編譯
