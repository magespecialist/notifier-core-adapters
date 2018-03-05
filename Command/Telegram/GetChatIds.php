<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierCoreAdapters\Command\Telegram;

use Magento\Framework\ObjectManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Helper\Table;

class GetChatIds extends Command
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * SendMessage constructor.
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        parent::__construct();
        $this->objectManager = $objectManager;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('msp:notifier:telegram:chat_ids');
        $this->setDescription('Print chat IDs for a TelegramBot token');

        $this->addArgument('token', InputArgument::REQUIRED, 'BOT Token');

        parent::configure();
    }

    /**
     * @inheritdoc
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // @codingStandardsIgnoreStart
        // Must use object manager here
        /** @var \MSP\NotifierCoreAdapters\Model\AdapterEngine\Telegram\GetChatIds $getChatIds */
        $getChatIds =
            $this->objectManager->get(\MSP\NotifierCoreAdapters\Model\AdapterEngine\Telegram\GetChatIds::class);
        // @codingStandardsIgnoreEnd

        $token = $input->getArgument('token');
        $chatIds = $getChatIds->execute($token);

        // @codingStandardsIgnoreStart
        $table = new Table($output);
        // @codingStandardsIgnoreEnd
        $table->setHeaders(['Chat ID', 'Name']);

        $tableRows = [];
        foreach ($chatIds as $chatId => $title) {
            $tableRows[] = [$chatId, $title];
        }

        $table->setRows($tableRows);
        $table->render();
    }
}
