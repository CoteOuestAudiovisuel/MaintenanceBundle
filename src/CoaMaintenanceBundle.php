<?php
namespace Coa\MaintenanceBundle;
use Coa\MaintenanceBundle\DependencyInjection\CoaMaintenanceExtension;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CoaMaintenanceBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $ext = new CoaMaintenanceExtension([],$container);


    }
}