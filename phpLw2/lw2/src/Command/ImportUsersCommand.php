<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

#[AsCommand(
    name: 'app:import-csv',
    description: ''
)]
class ImportUsersCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'название файла в папке files, например "users.csv"');
       
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fileName = $input->getArgument('file');
        $filePath = __DIR__ . '/files/' . $fileName;


        $logFile = __DIR__ . '/logs/process.log';
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) mkdir($logDir, 0777, true);

        $logger = function ($message, $level = 'INFO') use ($logFile) {
            $date = date('Y-m-d H:i:s');
            file_put_contents($logFile, "[$date] [$level] $message" . PHP_EOL, FILE_APPEND);
        };

        $logger("Начало обработки файла: $fileName");

        try {
            $reader = ReaderEntityFactory::createCSVReader($filePath);
            $reader->setFieldDelimiter(';');
            $reader->open($filePath);
        } catch (\Exception $e) {
            $logger("Критическая ошибка: " . $e->getMessage(), 'ERROR');
            $io->error("Не удалось открыть файл");
            return Command::FAILURE;
        }

        $totalRows = 0;

        $progressBar = $io->createProgressBar($totalRows);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s% ');
        $progressBar->start();

        foreach ($reader->getSheetIterator() as $sheet) {

            $rows = [];

            $invalidEmails = [];
            $processed = 0;
            $rowIndex = 0;

            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCells();
                $rowData = [];
                $totalRows++;
                foreach ($cells as $cell) {

                    $rowData[] = $cell->getValue();
                }


                if ($rowIndex > 0 && isset($rowData[1])) {
                    $email = $rowData[1];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !empty($email)) {
                        $invalidEmails[] = [$rowIndex + 1, $email];
                        $logger("Некорректный email в строке " . ($rowIndex + 1) . ": $email", 'WARNING');
                    }
                }
                $rows[] = $rowData;

                $rowIndex++;
                $processed++;
                $progressBar->setMessage("Строка $processed из $totalRows");
                $progressBar->advance();
            }

            $progressBar->finish();
            $io->newLine(2);

            if (!empty($rows)) {
                $headers = array_shift($rows);
                $io->table($headers, $rows);
            }
        }

        $reader->close();

        if (!empty($invalidEmails)) {
            $io->warning('Найдены некорректные email:');
            $io->table(['Строка', 'Email'], $invalidEmails);
            $logger("Найдено " . count($invalidEmails) . " некорректных email", 'WARNING');
        } else {
            $io->success('Все email корректны!');
            $logger("Все email корректны", 'INFO');
        }

        $logger("Обработка завершена. Всего строк: $processed");


        return Command::SUCCESS;
    }
}
