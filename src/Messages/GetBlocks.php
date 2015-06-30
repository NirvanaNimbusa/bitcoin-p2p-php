<?php

namespace BitWasp\Bitcoin\Network\Messages;

use BitWasp\Bitcoin\Network\NetworkSerializable;
use BitWasp\Bitcoin\Network\Serializer\Message\GetBlocksSerializer;
use BitWasp\Buffertools\Buffer;

class GetBlocks extends NetworkSerializable
{
    /**
     * @var int
     */
    private $version;

    /**
     * @var Buffer[]
     */
    private $hashes;

    /**
     * @var Buffer
     */
    private $hashStop;

    /**
     * @param int $version
     * @param Buffer[] $hashes
     */
    public function __construct(
        $version,
        array $hashes
    ) {
        $this->version = $version;
        $this->hashes = array_slice($hashes, 0, count($hashes) - 1);
        $this->hashStop = end($hashes);
    }

    /**
     * @return string
     */
    public function getNetworkCommand()
    {
        return 'getblocks';
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return Buffer[]
     */
    public function getHashes()
    {
        return $this->hashes;
    }

    /**
     * @return Buffer
     */
    public function getHashStop()
    {
        return $this->hashStop;
    }

    /**
     * @return \BitWasp\Buffertools\Buffer
     */
    public function getBuffer()
    {
        return (new GetBlocksSerializer())->serialize($this);
    }
}
