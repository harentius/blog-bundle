<?php

namespace Harentius\BlogBundle;

use Doctrine\Common\Cache\CacheProvider;
use Harentius\BlogBundle\Entity\Setting;
use Harentius\BlogBundle\Entity\SettingRepository;

class SettingsProvider
{
    /**
     * @var CacheProvider
     */
    private $cache;

    /**
     * @var SettingRepository
     */
    private $repository;

    /**
     * @param SettingRepository $repository
     * @param CacheProvider $cache
     */
    public function __construct(SettingRepository $repository, CacheProvider $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        if (!$this->cache->contains($key)) {
            $this->loadSettings();
        }

        return $this->cache->fetch($key);
    }

    /**
     *
     */
    public function clearCache()
    {
        $this->cache->deleteAll();
    }

    /**
     * @return array
     */
    private function loadSettings()
    {
        /** @var Setting $setting */
        foreach ($this->repository->findAll() as $setting) {
            $this->cache->save($setting->getKey(), $setting->getValue());
        }
    }
}
