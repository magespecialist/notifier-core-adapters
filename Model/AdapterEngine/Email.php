<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierCoreAdapters\Model\AdapterEngine;

use Magento\Framework\Mail\MessageInterface;
use MSP\Notifier\Model\AdapterEngine\AdapterEngineInterface;
use Magento\Framework\Mail\MessageInterfaceFactory;
use Magento\Framework\Mail\TransportInterfaceFactory;

class Email implements AdapterEngineInterface
{
    const ADAPTER_CODE = 'email';

    const ADAPTER_FROM = 'from';
    const ADAPTER_FROM_NAME = 'from_name';
    const ADAPTER_TO = 'to';

    /**
     * @var MessageInterfaceFactory
     */
    private $messageFactory;

    /**
     * @var TransportInterfaceFactory
     */
    private $transportFactory;

    /**
     * Email constructor.
     * @param MessageInterfaceFactory $messageFactory
     * @param TransportInterfaceFactory $transportFactory
     * @SuppressWarnings(PHPMD.LongVariables)
     */
    public function __construct(
        MessageInterfaceFactory $messageFactory,
        TransportInterfaceFactory $transportFactory
    ) {
        $this->messageFactory = $messageFactory;
        $this->transportFactory = $transportFactory;
    }

    /**
     * Execute engine and return true on success. Throw exception on failure.
     * @param string $message
     * @param array $params
     * @return bool
     * @throws \Magento\Framework\Exception\MailException
     */
    public function execute(string $message, array $params = []): bool
    {
        $lines = explode("\n", $message);
        $to = preg_split("/\\r\\n/", $params['to']);

        $emailMessage = $this->messageFactory->create();

        $emailMessage->setFrom($params['from'], $params['from_name']);
        $emailMessage->addTo($to);
        $emailMessage->setMessageType(MessageInterface::TYPE_HTML);
        $emailMessage->setBody($message);
        $emailMessage->setSubject($lines[0]);

        $transport = $this->transportFactory->create(['message' => $emailMessage]);
        $transport->sendMessage();

        return true;
    }
}
