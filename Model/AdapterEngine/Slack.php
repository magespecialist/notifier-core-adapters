<?php
/**
* Copyright © MageSpecialist - Skeeller srl. All rights reserved.
* See COPYING.txt for license details.
*/

declare(strict_types=1);

namespace MSP\NotifierCoreAdapters\Model\AdapterEngine;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Maknz\Slack\Client;
use MSP\Notifier\Model\AdapterEngine\AdapterEngineInterface;

class Slack implements AdapterEngineInterface
{
    const PARAM_COLOR = 'color';
    const PARAM_EMOJI  = 'emoji';
    const PARAM_CHANNEL = 'channel';
    const PARAM_WEBHOOK = 'webhook';

    const DEFAULT_EMOJI = ':bear:';
    const DEFAULT_COLOR = '#333333';

    const ADAPTER_CODE = 'slack';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Slack constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Execute engine and return true on success. Throw exception on failure.
     * @param string $emailMessage
     * @param array $params
     * @return bool
     */
    public function execute(string $emailMessage, array $params = []): bool
    {
        $client = $this->getClient($params);

        $client->attach([
            'fallback' => $emailMessage,
            'text' => $emailMessage,
            'color' => $params[static::PARAM_COLOR] ?: static::DEFAULT_COLOR
        ])->send();

        return true;
    }

    /**
     * @param array $params
     * @return array
     */
    private function paramsToSettings(array $params): array
    {
        return [
            'userName' => $this->scopeConfig->getValue('general/store_information/name'),
            'channel' => $params[static::PARAM_CHANNEL],
            'icon' => $params[static::PARAM_EMOJI] ?: static::DEFAULT_EMOJI
        ];
    }

    /**
     * @param array $params
     * @return Client
     */
    private function getClient(array $params): Client
    {
        $settings = $this->paramsToSettings($params);
        // @codingStandardsIgnoreStart
        return new Client($params[static::PARAM_WEBHOOK], $settings);
        // @codingStandardsIgnoreEnd
    }
}
