<?php

namespace Harentius\BlogBundle\Admin\Controller;

use Harentius\BlogBundle\Assets\Resolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileBrowseController extends AbstractController
{
    /**
     * @var Resolver
     */
    private $assetsResolver;

    /**
     * FileBrowseController constructor.
     * @param Resolver $assetsResolver
     */
    public function __construct(Resolver $assetsResolver)
    {
        $this->assetsResolver = $assetsResolver;
    }

    /**
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function __invoke(Request $request, $type = 'image')
    {
        if (!in_array($type, ['image', 'audio'], true)) {
            throw new \InvalidArgumentException(sprintf("Unknown files type '%s", $type));
        }

        $directory = $this->assetsResolver->assetPath($type);
        $files = [];
        $finder = new Finder();
        $finder
            ->files()
            ->in($directory)
            ->ignoreDotFiles(true)
        ;

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $uri = $this->assetsResolver->pathToUri($file->getPathname());

            if ($uri) {
                $files[$uri] = pathinfo($uri, PATHINFO_BASENAME);
            }
        }

        return $this->render(sprintf('@HarentiusBlog/Admin/ckeditor/ck_browse_%ss.html.twig', $type), [
            'func_num' => $request->query->get('CKEditorFuncNum'),
            'files' => $files,
        ]);
    }
}
