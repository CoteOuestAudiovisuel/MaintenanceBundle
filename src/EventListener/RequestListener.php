<?php
namespace Coa\MaintenanceBundle\EventListener;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;


class RequestListener
{
    private ContainerBagInterface $container;
    private Environment $twig;

    public function __construct(ContainerBagInterface $container, Environment $twig){

        $this->container = $container;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if($event->isMainRequest()){
            if(file_exists($this->container->get('kernel.project_dir')."/.maintenance")){
                $content = $this->twig->render("@CoaMaintenance/home/index.html.twig",[]);
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