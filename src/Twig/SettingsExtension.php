<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Twig;

use Harentius\BlogBundle\Entity\SettingRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SettingsExtension extends AbstractExtension
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('get_setting', [$this, 'getSetting']),
        ];
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getSetting(string $key): ?string
    {
        $setting = $this->settingRepository->findOneBy(['key' => $key]);

        return $setting ? $setting->getValue() : null;
    }
}
