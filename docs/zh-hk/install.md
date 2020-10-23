# 擴展安裝

Swow 擴展安裝提供了以下幾種方法

## 編譯安裝

下載或者 clone 源代碼後，在終端進入源碼目錄，執行下面的命令進行編譯和安裝

```shell
git clone git@github.com:swow/swow.git

cd swow
phpize
./configure
make
sudo make install
```

!> 編譯成功後，在使用時推薦通過 `-d` 來加載 Swow 擴展，如：`php -d extension=swow`

## Composer

可以使用 Composer 下載源碼

```shell
composer require swow/swow
```

下載完成後在 `vendor/bin` 目錄中會有一個 `swow-builder` 的文件，我們可以使用此腳本文件來安裝擴展

此腳本提供了4個參數，分別為`rebuild`, `show-log`, `debug`, `enable`，支持同時多個參數，示例如下

```shell
#編譯擴展
php vendor/bin/swow-builder

#重新編譯擴展
php vendor/bin/swow-builder --rebuild

#編譯擴展時顯示完整編譯日誌信息
php vendor/bin/swow-builder --show-log

#編譯擴展並打開擴展的調試模式
php vendor/bin/swow-builder --debug

#編譯擴展時增加一些編譯參數
php vendor/bin/swow-builder --enable="--enable-debug"
```

!> 編譯成功後，在使用時推薦通過 `-d` 來加載 Swow 擴展，如：`php -d extension=swow`

## 編譯參數

* `--enable-debug`

打開調試模式
