<?php

declare(strict_types=1);

namespace LongHoang\ImportProduct\Console\Command;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\State;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\ImportExport\Model\Import\Source\CsvFactory;
use Magento\ImportExport\Model\ImportFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class import product command
 */
class ImportProduct extends Command
{
    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var State
     */
    private $state;

    /**
     * @var ImportFactory
     */
    private $importFactory;

    /**
     * @var CsvFactory
     */
    private $csvFactory;

    /**
     * @var ReadFactory
     */
    private $readFactory;

    /**
     * @param DirectoryList $directoryList
     * @param State $state
     * @param ImportFactory $importFactory
     * @param CsvFactory $csvFactory
     * @param ReadFactory $readFactory
     * @param string|null $name
     */
    public function __construct(
        DirectoryList $directoryList,
        State $state,
        ImportFactory $importFactory,
        CsvFactory $csvFactory,
        ReadFactory $readFactory,
        string $name = null
    ) {
        $this->directoryList = $directoryList;
        $this->state = $state;
        $this->importFactory = $importFactory;
        $this->csvFactory = $csvFactory;
        $this->readFactory = $readFactory;
        parent::__construct($name);
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('custom:import:product');
        $this->setDescription('This is import large size products file command');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode('adminhtml');
            $this->importProduct($output);
        } catch (\Exception $e) {
            $output->writeln(__('<error>Unable to import products.</error>'));
        }
    }

    /**
     * @param OutputInterface $output
     * @return void
     * @throws FileSystemException
     * @throws LocalizedException
     */
    private function importProduct(OutputInterface $output): void
    {
        $filename = 'import_product_*_.csv';
        $file = $this->directoryList->getPath('var') . '/import/product/' . $filename;

        $importFile = pathinfo($file);
        $import = $this->importFactory->create();
        $import->setData(
            [
                'entity' => 'catalog_product',
                'behavior' => 'append',
                'validation_strategy' => 'validation-stop-on-errors',
            ]
        );

        $readFile = $this->readFactory->create($importFile['dirname']);
        $csvSource = $this->csvFactory->create([
            'file' => $importFile['basename'],
            'directory' => $readFile,
        ]);

        $validate = $import->validateSource($csvSource);
        if (!$validate) {
            $output->writeln('<error>The CSV is invalid.</error>');
        }

        $result = $import->importSource();
        if ($result) {
            $import->invalidateIndex();
        }
        $output->writeln("<info>Finished importing products from $file</info>");
    }
}
