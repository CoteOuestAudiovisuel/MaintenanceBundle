<?php
namespace Coa\MaintenanceBundle\EventListener;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;


class RequestListener
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container){

        $this->container = $container;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if($event->isMainRequest()){
            $response = $this->container->get('twig')->render("@CoaMaintenanceBundle/home/index.html.twid",[]);
            $response->headers->set("Location","/maintenance");
            $response->setStatusCode(Response::HTTP_TEMPORARY_REDIRECT);
            $event->setResponse($response);
            $event->stopPropagation();
        }
    }
}