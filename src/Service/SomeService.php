<?php


namespace App\Service;


use MetroMarkets\FFBundle\FeatureFlagService;

class SomeService
{
    private FeatureFlagService $featureFlagService;

    public function __construct(FeatureFlagService $featureFlagService)
    {
        $this->featureFlagService = $featureFlagService;
    }

    public function isEnabled()
    {
        return $this->featureFlagService->isEnabled('isAwesomeFeatureEnabled');

    }

    public function doSomething()
    {
        $isEnabled = $this->isEnabled();

        if ($isEnabled) {
            return 'Yo! It\'s on!';
        } else {
            return 'Old is always better';
        }
    }

}