<?php
namespace Coa\MaintenanceBundle\EventListener;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
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
            if(file_exists($this->container->getParameter('kernel.project_dir')."/.maintenance")){
                $content = $this->container->get('twig')->render("@CoaMaintenance/home/index.html.twig",[]);
                $response = new Response();
                $response->setContent($content);
                $response->headers->set("Cache-Control","public, max-age=300");
                $response->setStatusCode(Response::HTTP_OK);
                $event->setResponse($response);
                $event->stopPropagation();
            }
        }
    }
}