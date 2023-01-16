<?php

namespace DigitalMarketingFramework\Typo3\Cache\Registry\EventListener;

use DigitalMarketingFramework\Core\Cache\DataCache;
use DigitalMarketingFramework\Typo3\Cache\Cache\Typo3Cache;
use DigitalMarketingFramework\Typo3\Core\Registry\Event\CoreRegistryServiceUpdateEvent;

class CoreRegistryServiceUpdateEventListener
{
    public function __construct(
        protected Typo3Cache $cache,
    ) {
    }

    public function __invoke(CoreRegistryServiceUpdateEvent $event): void
    {
        $registry = $event->getRegistry();
        $event->getRegistry()->setCache(
            $registry->createObject(DataCache::class, [$this->cache])
        );
    }
}
