# 擴充套件安裝

Swow 擴充套件安裝提供了以下幾種方法

## 編譯安裝

下載或者 clone 原始碼後，在終端進入原始碼目錄，執行下面的命令進行編譯和安裝

```shell
git clone git@github.com:swow/swow.git

cd swow
phpize
./configure
make
sudo make install
```

!> 編譯成功後，不要忘記在 php.ini 中加入一行 `extension=swow.so` 來啟用 Swow 擴充套件

## Composer

可以使用 Composer 下載原始碼

```shell
composer require swow/swow
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

!> 編譯成功後，不要忘記在 php.ini 中加入一行 `extension=swow.so` 來啟用 Swow 擴充套件

## 編譯引數

* `--enable-debug`

開啟除錯模式