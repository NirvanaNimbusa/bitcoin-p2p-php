<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Tests\Networking\Settings;

use BitWasp\Bitcoin\Networking\DnsSeeds\DnsSeedList;
use BitWasp\Bitcoin\Networking\Settings\MainnetSettings;
use BitWasp\Bitcoin\Networking\Settings\NetworkSettings;
use PHPUnit\Framework\TestCase;

class NetworkSettingsMutabilityTest extends TestCase
{
    /**
     * @var NetworkSettings
     */
    private $settings;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->settings = new MainnetSettings();
    }

    public function testWithDnsSeeds()
    {
        $initialList = $this->settings->getDnsSeedList();

        $seedList = new DnsSeedList([]);
        $settings = $this->settings->withDnsSeeds($seedList);
        $this->assertSame($seedList, $settings->getDnsSeedList());
        $this->assertNotSame($initialList, $settings->getDnsSeedList());
        $this->assertNotSame($settings, $this->settings);
    }

    public function testWithConnectionTimeout()
    {
        $connectionTimeout = $this->settings->getConnectionTimeout();

        $newTimeout = 1234242;
        $settings = $this->settings->withConnectionTimeout($newTimeout);
        $this->assertSame($newTimeout, $settings->getConnectionTimeout());
        $this->assertNotSame($connectionTimeout, $settings->getConnectionTimeout());
        $this->assertNotSame($settings, $this->settings);
    }

    public function testWithMaxRetries()
    {
        $retries = $this->settings->getMaxConnectRetries();

        $newRetries = 221;
        $settings = $this->settings->withMaxConnectRetries($newRetries);
        $this->assertSame($newRetries, $settings->getMaxConnectRetries());
        $this->assertNotSame($retries, $settings->getMaxConnectRetries());
        $this->assertNotSame($settings, $this->settings);
    }

    public function testNoDnsServer()
    {
        $firstServer = $this->settings->getDnsServer();
        $settings = $this->settings->withDnsServer(null);
        $this->assertEquals($firstServer, $this->settings->getDnsServer());
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Missing DNS server");
        $settings->getDnsServer();
    }

    public function testNoDnsSeeds()
    {
        $firstSeeds = $this->settings->getDnsSeedList();
        $settings = $this->settings->withDnsSeeds(null);
        $this->assertSame($firstSeeds, $this->settings->getDnsSeedList());
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Missing DNS seed list");
        $settings->getDnsSeedList();
    }

    public function testWithDnsServer()
    {
        $server = "8.8.8.8";
        $settings = $this->settings->withDnsServer($server);
        $this->assertSame($server, $settings->getDnsServer());
        $this->assertNotSame($settings, $this->settings);
    }

    public function testWithDefaultP2PPort()
    {
        $initialPort = $this->settings->getDefaultP2PPort();
        $port = 12311;
        $settings = $this->settings->withDefaultP2PPort($port);
        $this->assertSame($port, $settings->getDefaultP2PPort());
        $this->assertNotSame($initialPort, $settings->getDefaultP2PPort());
        $this->assertNotSame($settings, $this->settings);
    }
}
