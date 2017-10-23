<?php

namespace Harentius\BlogBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as BaseCRUDController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CRUDController extends BaseCRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function uploadAction(Request $request)
    {
        $manager = $this->get('harentius_blog.assets.manager');
        $assetFile = $manager->handleUpload($request->files->get('upload'));

        return $this->render('HarentiusBlogBundle:Admin:ck_upload.html.twig', [
            'func_num' => $request->query->get('CKEditorFuncNum'),
            'uri' => $assetFile->getUri(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function browseAction(Request $request, $type = 'image')
    {
        if (!in_array($type, ['image', 'audio'], true)) {
            throw new \InvalidArgumentException(sprintf("Unknown files type '%s", $type));
        }

        $resolver = $this->get('harentius_blog.assets.resolver');
        $directory = $resolver->assetPath($type);
        $files = [];
        $finder = new Finder();
        $finder
            ->files()
            ->in($directory)
            ->ignoreDotFiles(true)
        ;

        /** @var SplFileInfo $file */
        foreach ($finder as $file) {
            $uri = $resolver->pathToUri($file->getPathname());

            if ($uri) {
                $files[$uri] = pathinfo($uri, PATHINFO_BASENAME);
            }
        }

        return $this->render(sprintf('HarentiusBlogBundle:Admin:ck_browse_%ss.html.twig', $type), [
            'func_num' => $request->query->get('CKEditorFuncNum'),
            'files' => $files,
        ]);
    }
}
