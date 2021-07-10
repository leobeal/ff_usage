<?php

namespace App\Controller;

use App\Service\SomeService;
use ConfigCat\ConfigFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultController extends AbstractController
{
    private SomeService $someService;

    public function __construct(SomeService $someService)
    {
        $this->someService = $someService;
    }


    #[Route('/default', name: 'default')]
    public function index(CacheInterface $cache): Response
    {
        $cacheContent = $this->getCachedData($cache);

        return new JsonResponse([
            'enabled' => $this->someService->isEnabled(),
            'message' => $this->someService->doSomething(),
            'cache_details_debug' => $cacheContent
        ]);
    }

    private function getCachedData($cache)
    {
        $sdkKey = 'PKDVCLf-Hq-h-kCzMp-L7Q/HhOWfwVtZ0mb30i9wi17GQ';

        // this hash is generated by configcat php SDK.
        $key = sha1(sprintf("php_" . ConfigFetcher::CONFIG_JSON_NAME . "_%s", $sdkKey));

        return $cache->get($key, function (ItemInterface $item) {

        });
    }
}
