# クワシロバスター

[![Build Status](https://travis-ci.org/tsmsogn/KuwashiroBuster.svg?branch=master)](https://travis-ci.org/tsmsogn/KuwashiroBuster)

## これは何？

http://www.pref.kyoto.jp/chaken/seika_kuwashiro.html を PHP で実装したものです

## 必要なもの

- PHP 5.3+

## インストール

```shell
composer require tsmsogn/kuwashiro-buster
```

## 使い方

### 基本的な使い方

```php
<?php

use KuwashiroBuster\Constraints\Generation;
use KuwashiroBuster\Kuwashiro\Kuwashiro;

// クワシロカイガラムシを作る
$kuwashiro = new Kuwashiro(Generation::GENERATION_1);

// 孵化するまで育てる
while (!$kuwashiro->isHatch()) {
    
    // 有効積算温度を取得する
    $yukoSekisanOndo = $kuwashiro->getYukoSekisanOndo();
    // 現在の有効積算温度を取得する
    $currentYukoSekisanOndo = $kuwashiro->getCurrentYukioSekisanOndo();
    
    echo sprintf('(有効積算温度, 現在の有効積算温度) = (%s, %s)', $yukoSekisanOndo, $currentYukoSekisanOndo) . "\n";

    // 気温 20℃で育てる
    $kuwashiro->grow(20);
}
```
