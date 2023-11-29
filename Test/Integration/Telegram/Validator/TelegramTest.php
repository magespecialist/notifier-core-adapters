<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\NotifierCoreAdapters\Test\Integration\Telegram\Validator;

use Magento\TestFramework\Helper\Bootstrap;
use MSP\NotifierApi\Api\AdapterInterface;

class TelegramTest extends \PHPUnit\Framework\TestCase
{
    /** @var AdapterInterface */
    private $adapterTelegram;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        // @codingStandardsIgnoreStart
        $this->adapterTelegram = Bootstrap::getObjectManager()->get(
            'MSP\NotifierCoreAdapters\Model\Adapter\Telegram'
        );
        // @codingStandardsIgnoreEnd
    }

    /**
     * Test message validation
     */
    public function testInvalidMessage()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->adapterTelegram->validateMessage('');

        $this->expectException(\InvalidArgumentException::class);
        $this->adapterTelegram->validateMessage(' ');
    }

    /**
     * Test message validation
     */
    public function testValidMessage()
    {
        $this->assertTrue($this->adapterTelegram->validateMessage('0'));
        $this->assertTrue($this->adapterTelegram->validateMessage('Hello world!'));
    }

    /**
     * Test params validation
     */
    public function testInvalidParams()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->adapterTelegram->validateParams([
            'token' => null,
        ]);
    }

    /**
     * Test params validation
     */
    public function testValidParams()
    {
        $this->assertTrue($this->adapterTelegram->validateParams([
            'token' => uniqid(),
            'chat_id' => 123,
        ]));
    }
}
