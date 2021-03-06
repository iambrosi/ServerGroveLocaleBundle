<?php

namespace ServerGrove\LocaleBundle\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ServerGrove\LocaleBundle\Asset\Factory\AssetFactory;

/**
 * Class
 *
 * @author Ismael Ambrosi<ismael@servergrove.com>
 */
class FlagExtensionFactory
{

    /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    /** @var bool */
    private $hideCurrentLocale;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     * @param bool               $hideCurrentLocale
     */
    public function __construct(ContainerInterface $container, $hideCurrentLocale)
    {
        $this->container         = $container;
        $this->hideCurrentLocale = $hideCurrentLocale;
    }

    public function get(AssetFactory $factory, $template, array $domains)
    {
        $extension = new FlagExtension($factory, $template, $domains);

        if ($this->hideCurrentLocale && $this->container->isScopeActive('request')) {
            /** @var $request \Symfony\Component\HttpFoundation\Request */
            $request = $this->container->get('request');
            $extension->hideLocale($request->getLocale());
        }

        return $extension;
    }
}
