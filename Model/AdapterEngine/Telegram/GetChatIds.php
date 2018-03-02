<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierCoreAdapters\Model\AdapterEngine\Telegram;

class GetChatIds
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * GetChatIds constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(
        ClientRepository $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Get a telegram client by token
     * @param string $token
     * @return array
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function execute(string $token): array
    {
        $bot = $this->clientRepository->get($token);
        $updates = $bot->getUpdates();

        $res = [];
        foreach ($updates as $update) {
            $message = $update->get('message');
            if ($message) {
                $chat = $message->get('chat');
                $chatId = $chat->get('id');

                if ($chat->get('title')) {
                    $res[$chatId] = $chat->get('title');
                } else {
                    $res[$chatId] = $chat->get('username');
                }
            }
        }

        return $res;
    }
}
