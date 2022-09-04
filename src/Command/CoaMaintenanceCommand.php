<?php
namespace Coa\MaintenanceBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CoaMaintenanceCommand extends Command
{
    protected static $defaultName = 'coa:maintenance';
    protected static $defaultDescription = 'Mets le site en mode maintenance';
    private ContainerBagInterface $container;

    public function __construct(string $name = null,ContainerBagInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure(): void
    {
        $this
            ->addOption('status', null, InputOption::VALUE_REQUIRED, 'pour activer ou desactive le mode maintenance')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $mode = filter_var($input->getOption('status'),FILTER_VALIDATE_BOOLEAN);
        $io->title("Mode maintenance");

        // activation du mode maintenance
        $filename = $this->container->get('kernel.project_dir') . "/.maintenance";
        if($mode == true){
            $io->note("Activation mode maintenance");
            if(!file_exists($filename)){
                file_put_contents($filename,"on");
                $io->success("Mode maintenance activé");
            }
            else{
                $io->error("Mode maintenance déja activé");
            }
        }
        else{
            $io->note("Desactivation mode maintenance");
            if(file_exists($filename)){
                @unlink($filename);
                $io->success("Mode maintenance désactivé");
            }
            else{
                $io->error("Mode maintenance déja désactivé");
            }
        }
        return Command::SUCCESS;
    }
}
