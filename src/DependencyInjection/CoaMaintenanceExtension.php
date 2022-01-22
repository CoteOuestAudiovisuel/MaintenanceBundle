<?php
namespace Coa\MaintenanceBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * CoaMaintenanceExtension
 */
class CoaMaintenanceExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $config = $this->processConfiguration(new Configuration(), $configs);
        $container->setParameter('coa_maintenance', $config);

        foreach ($config as $k=>$v){
            $container->setParameter("coa_maintenance.$k", $v);
        }
    }


    public function prepend(ContainerBuilder $container)
    {
        $twigConfig = [];
        $twigConfig['paths'][__DIR__.'/../Resources/views'] = "coa_maintenance";
        $twigConfig['paths'][__DIR__.'/../Resources/public'] = "coa_maintenance.public";
        $container->prependExtensionConfig('twig', $twigConfig);
    }
}