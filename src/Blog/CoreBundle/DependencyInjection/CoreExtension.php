<?php

namespace Blog\CoreBundle\DependencyInjection;
use Symfony\Bundle\DebugBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Created by PhpStorm.
 * User: chrisshayan
 * Date: 4/14/17
 * Time: 1:01 AM
 */
class CoreExtension extends Extension {

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this -> processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader -> load('services.yml');
    }
}