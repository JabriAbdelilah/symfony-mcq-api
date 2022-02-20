<?php

namespace App\Command;

use App\Service\QuestionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class QuestionPopulateCommand extends Command
{
    protected static $defaultName = 'question:populate';
    protected static $defaultDescription = 'Populate the database from certificationy/symfony-pack Repository';

    private QuestionService $questionService;

    public function __construct(QuestionService $questionService)
    {
        parent::__construct();
        $this->questionService = $questionService;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $filesList = $this->questionService->getFilesList();

        foreach ($filesList as $file) {
            $fileContent = $this->questionService->getFileContent($file['path']);
        }

        return Command::SUCCESS;
    }
}
