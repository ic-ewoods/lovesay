<?php

namespace LoveSay;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Admin extends Command
{
    protected function configure()
    {
        $this
            ->setName('add')
            ->setDescription('Add a note')
            ->addArgument(
                'note',
                InputArgument::REQUIRED
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $note = new Note($input->getArgument('note'));

        $text = 'Note to add:' . PHP_EOL . "\t" . $note->getText();

        $note_repository = new NoteRepository();
        $note_repository->addNote($note);

        $output->writeln($text);
    }
}
