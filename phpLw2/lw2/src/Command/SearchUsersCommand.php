<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


#[AsCommand(
    name: 'app:search-users',
    description: '',
)]
class SearchUsersCommand extends Command
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addOption('email', null, InputOption::VALUE_OPTIONAL, 'Фильтр по домену')
            ->addOption('active', null, InputOption::VALUE_OPTIONAL, 'Фильтр по статусу (1 | 0)');
    }


    protected function search(string|null $email, bool|null $active): array
    {
        $qb = $this-> entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        if ($email) {
            if (str_contains($email, '.') && !str_contains($email, '@')) {
                $qb->andWhere('u.email LIKE :domain')
                    ->setParameter('domain', '%@' . $email);
            }
        }

        if ($active !== null) {
            $qb->andWhere('u.status = :active')
                ->setParameter('active', (bool)$active);
        }

        $users = $qb->getQuery()->getResult();

        return $users;
    }

    protected function execute(InputInterface $input, OutputInterface $output,): int
    {

        $io = new SymfonyStyle($input, $output);

        $email = $input->getOption('email');
        $active = $input->getOption('active');

        $users = $this->search($email, $active);

        $tableData = [];
        foreach ($users as $user) {
            $tableData[] = [
                $user->getId(),
                $user->getEmail(), 
                $user->isStatus()
            ];
        }

        $io->table(['ID', 'Email', 'Active'], $tableData);

        return Command::SUCCESS;
    }
}
