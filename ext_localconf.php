<?php

use TYPO3\CMS\Core\Cache\Frontend\VariableFrontend;
use DigitalMarketingFramework\Typo3\Cache\Cache\Typo3Cache;

defined('TYPO3') || die('Access denied.');

(function() {
    if (!array_key_exists(Typo3Cache::CACHE_IDENTIFIER, $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][Typo3Cache::CACHE_IDENTIFIER] = [
            'frontend' => VariableFrontend::class,
            'options' => [
                'defaultLifetime' => Typo3Cache::DEFAULT_LIFETIME,
            ],
            'groups' => ['pages', 'all'],
        ];
    }
})();
