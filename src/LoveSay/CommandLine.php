<?php

namespace LoveSay;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandLine extends Command
{

    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Returns a random note');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $random_note = new RandomNote();
        $output->writeln($random_note->getNote());
    }
}
