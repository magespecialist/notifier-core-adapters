<?php
/**
 * Copyright © MageSpecialist - Skeeller srl. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace MSP\NotifierCoreAdapters\Model\AdapterEngine\Telegram;

use Telegram\Bot\Api;

class ClientRepository
{
    private $clients = [];

    /**
     * Get a telegram client by token
     * @param string $token
     * @return Api
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function get(string $token): Api
    {
        if (!isset($this->clients[$token])) {
            // @codingStandardsIgnoreStart
            $this->clients[$token] = new Api($token);
            // @codingStandardsIgnoreEnd
        }

        return $this->clients[$token];
    }
}
