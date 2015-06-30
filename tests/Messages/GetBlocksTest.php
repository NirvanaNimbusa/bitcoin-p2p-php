<?php

namespace BitWasp\Bitcoin\Network\Tests\Messages;

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Network\MessageFactory;
use BitWasp\Bitcoin\Network\Tests\AbstractTestCase;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Parser;

class GetBlocksTest extends AbstractTestCase
{
    public function testNetworkSerializer()
    {
        $net = Bitcoin::getDefaultNetwork();
        $factory = new MessageFactory($net, new Random());

        $getblocks = $factory->getblocks(
            '1',
            [
                Buffer::hex('4141414141414141414141414141414141414141414141414141414141414141'),
                Buffer::hex('0000000000000000000000000000000000000000000000000000000000000000')
            ]
        );

        $serialized = $getblocks->getNetworkMessage()->getBuffer();
        $parsed = $factory->parse(new Parser($serialized))->getPayload();
        $this->assertEquals($getblocks, $parsed);
    }
}