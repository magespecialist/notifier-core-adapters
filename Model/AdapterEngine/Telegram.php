<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierCoreAdapters\Model\AdapterEngine;

use MSP\Notifier\Model\AdapterEngine\AdapterEngineInterface;
use MSP\NotifierCoreAdapters\Model\AdapterEngine\Telegram\ClientRepository;

class Telegram implements AdapterEngineInterface
{
    const ADAPTER_CODE = 'telegram';
    const PARAM_TOKEN = 'token';
    const PARAM_CHAT_ID = 'chat_id';

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * Telegram constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(
        ClientRepository $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Execute engine and return true on success. Throw exception on failure.
     * @param string $message
     * @param array $params
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function execute(string $message, array $params = []): bool
    {
        $client = $this->clientRepository->get($params[self::PARAM_TOKEN]);
        $client->sendMessage([
            'chat_id' => $params[self::PARAM_CHAT_ID],
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        return true;
    }
}
