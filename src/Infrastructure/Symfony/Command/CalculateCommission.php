<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Command;

use App\Application\UseCase\CalculateCommission\CalculateCommissionCommand;
use App\Application\UseCase\CalculateCommission\CalculateCommissionHandler;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CalculateCommission extends Command
{
    public function __construct(private readonly CalculateCommissionHandler $calculateCommissionHandler, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('app:calculate-commission');
        $this->addArgument(
            'transactions',
            InputArgument::REQUIRED,
            'Transactions list (ex: transactions.txt)'
        );
    }

//    #[AsCommand(name: 'app:calculate-commission')]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!file_exists($input->getArgument('transactions')) || !is_readable($input->getArgument('transactions'))) {
            $output->writeln(sprintf('%s: File can not be opened', $input->getArgument('transactions')));
            return Command::INVALID;
        }

        // todo use one-line-reader instead of file() call
        foreach (file($input->getArgument('transactions')) as $row) {
            $row = json_decode($row);

            try {
                $output->writeln(
                    sprintf('Commission for BIN %s is: %f', $row->bin,
                        $this->calculateCommissionHandler->handle(
                            new CalculateCommissionCommand(
                                (int)$row->bin,
                                (float)$row->amount,
                                $row->currency
                            )
                        )
                    ));
            } catch (Exception $e) {
                $output->writeln(sprintf('%s: %s', $row->bin, $e->getMessage()));
            }
        }

        return Command::SUCCESS;
    }
}
