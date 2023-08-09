<?php

namespace DigitalMarketingFramework\Typo3\Cache\Registry\EventListener;

use DigitalMarketingFramework\Core\Cache\DataCache;
use DigitalMarketingFramework\Core\Registry\RegistryUpdateType;
use DigitalMarketingFramework\Typo3\Cache\Cache\Typo3Cache;
use DigitalMarketingFramework\Typo3\Core\Registry\Event\CoreRegistryUpdateEvent;

class CoreRegistryUpdateEventListener
{
    public function __construct(
        protected Typo3Cache $cache,
    ) {
    }

    public function __invoke(CoreRegistryUpdateEvent $event): void
    {
        if ($event->getUpdateType() !== RegistryUpdateType::SERVICE) {
            return;
        }

        $registry = $event->getRegistry();
        $event->getRegistry()->setCache(
            $registry->createObject(DataCache::class, [$this->cache])
        );
    }
}
