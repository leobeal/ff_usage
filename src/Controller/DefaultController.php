<?php

namespace App\Controller;

use ConfigCat\ConfigFetcher;
use MetroMarkets\FFBundle\FeatureFlagService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultController extends AbstractController
{
    /** @var FeatureFlagService */
    private $featureFlagService;

    public function __construct(FeatureFlagService $featureFlagService)
    {
        $this->featureFlagService = $featureFlagService;
    }

    #[Route('/default', name: 'default')]
    public function index(CacheInterface $cache): Response
    {
        $cacheContent = $this->getCachedData($cache);

        $isEnabled = $this->featureFlagService->isEnabled('isAwesomeFeatureEnabled');

        return new JsonResponse([
            'enabled' => $isEnabled,
            'cache_details' => $cacheContent
        ]);
    }

    private function getCachedData($cache)
    {
        $sdkKey = 'PKDVCLf-Hq-h-kCzMp-L7Q/HhOWfwVtZ0mb30i9wi17GQ';

        $key = sha1(sprintf("php_" . ConfigFetcher::CONFIG_JSON_NAME . "_%s", $sdkKey));

        return $cache->get($key, function (ItemInterface $item) {

        });
    }
}
