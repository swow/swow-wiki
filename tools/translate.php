#!/usr/bin/env php
<?php
/**
 * Run this PHP script to generate the zh-tw and zh-hk documentations via zh-cn.
 *
 * @notice Please DO NOT run this script manually, when you trying to submit a Pull Request of Documentation.
 */

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/tools/vendor/autoload.php';

use Symfony\Component\Finder\Finder;

$config = [
    'zh-tw' => [
        'targetDir' => ROOT_DIR . '/docs/zh-tw/',
        'rule' => 's2twp.json',
    ],
    'zh-hk' => [
        'targetDir' => ROOT_DIR . '/docs/zh-hk/',
        'rule' => 's2hk.json',
    ],
];

$finder = new Finder();
$finder->files()->in(ROOT_DIR . '/docs/zh-cn');

foreach ($config as $key => $item) {
    $od = opencc_open($item['rule']);
    foreach ($finder as $fileInfo) {
        $targetDir = $item['targetDir'];
        $targetPath = $targetDir . $fileInfo->getRelativePath();
        $isCreateDir = false;
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
            chmod($targetPath, 0777);
            $isCreateDir = true;
        }
        if (!is_writable($targetPath)) {
            echo sprintf('Target path %s is not writable.' . PHP_EOL, $targetPath);
        }
        if ($fileInfo->getExtension() === 'md') {
            $translated = opencc_convert($fileInfo->getContents(), $od);
            $translated = str_replace('](zh-cn/', '](' . $key . '/', $translated);
            $translated = str_replace('](./zh-cn/', '](./' . $key . '/', $translated);
            $targetTranslatedPath = $targetDir . $fileInfo->getRelativePathname();
            @file_put_contents($targetTranslatedPath, $translated);
        } else {
            $targetTranslatedPath = $targetDir . $fileInfo->getRelativePathname();
            @copy($fileInfo->getRealPath(), $targetTranslatedPath);
        }
    }
    opencc_close($od);
}
