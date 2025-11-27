<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

$iconList = [];
foreach ([
    'extension-jvadvent' => 'extension.svg',
] as $identifier => $path) {
    $iconList[$identifier] = [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:jvadvent/Resources/Public/Icons/' . $path,
    ];
}

return $iconList;
