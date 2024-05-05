<?php

namespace DigitalMarketingFramework\Typo3\Cache\Cache;

use DigitalMarketingFramework\Core\Cache\CacheInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;

class Typo3Cache implements CacheInterface
{
    /**
     * @var string
     */
    public const CACHE_IDENTIFIER = 'digitalmarketingframework_cache';

    /**
     * @var int
     */
    public const DEFAULT_LIFETIME = 1800;

    protected FrontendInterface $cache;

    protected int $timeout = self::DEFAULT_LIFETIME;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cache = $cacheManager->getCache(static::CACHE_IDENTIFIER);
    }

    public function setTimeoutInSeconds(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    public function getTimeoutInSeconds(): int
    {
        return $this->timeout;
    }

    /**
     * @return ?array<mixed>
     */
    public function fetch(string $key): ?array
    {
        $result = $this->cache->get($key);

        return $result === false ? null : $result;
    }

    /**
     * @param array<string> $keys
     *
     * @return array<array<mixed>>
     */
    public function fetchMultiple(array $keys): array
    {
        $results = [];
        foreach ($keys as $key) {
            $result = $this->fetch($key);
            if ($result !== null) {
                $results[] = $result;
            }
        }

        return $results;
    }

    public function purge(string $key): void
    {
        $this->cache->remove($key);
    }

    /**
     * @param array<string> $keys
     */
    public function purgeMultiple(array $keys): void
    {
        foreach ($keys as $key) {
            $this->purge($key);
        }
    }

    public function purgeExpired(): void
    {
        $this->cache->collectGarbage();
    }

    public function purgeAll(): void
    {
        $this->cache->flush();
    }

    /**
     * @param array<mixed> $data
     * @param array<string> $tags
     */
    public function store(string $key, array $data, int $timeoutInSeconds = -1, array $tags = []): void
    {
        $lifetime = $timeoutInSeconds > 0 ? $timeoutInSeconds : $this->getTimeoutInSeconds();
        $this->cache->set($key, $data, $tags, $lifetime);
    }

    /**
     * @param array<string> $tags
     */
    public function purgeByTags(array $tags): void
    {
        $this->cache->flushByTags($tags);
    }
}
