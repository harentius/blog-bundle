<?php

declare(strict_types=1);

namespace Harentius\BlogBundle\Twig;

use Harentius\BlogBundle\Entity\Article;
use Harentius\BlogBundle\Entity\TranslationRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TranslationListExtension extends AbstractExtension
{
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

    /**
     * @var string
     */
    private $primaryLocale;

    /**
     * @param TranslationRepository $translationRepository
     * @param string $primaryLocale
     */
    public function __construct(TranslationRepository $translationRepository, string $primaryLocale)
    {
        $this->translationRepository = $translationRepository;
        $this->primaryLocale = $primaryLocale;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('translations_list', [$this, 'translationsList']),
        ];
    }

    /**
     * @param Article $article
     * @return array
     */
    public function translationsList(Article $article): array
    {
        $translations = $this->translationRepository->findTranslations($article);

        return array_merge([$this->primaryLocale], $translations);
    }

}
