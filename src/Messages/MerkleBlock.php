<?php

namespace BitWasp\Bitcoin\Network\Messages;

use BitWasp\Bitcoin\Network\Structure\FilteredBlock;
use BitWasp\Bitcoin\Network\NetworkSerializable;
use BitWasp\Bitcoin\Serializer\Block\HexBlockHeaderSerializer;
use BitWasp\Bitcoin\Network\Serializer\Message\MerkleBlockSerializer;
use BitWasp\Bitcoin\Network\Serializer\PartialMerkleTreeSerializer;
use BitWasp\Bitcoin\Network\Serializer\Structure\FilteredBlockSerializer;


class MerkleBlock extends NetworkSerializable
{
    /**
     * @var FilteredBlock
     */
    private $merkle;

    /**
     * @param FilteredBlock $merkleBlock
     */
    public function __construct(FilteredBlock $merkleBlock)
    {
        $this->merkle = $merkleBlock;
    }

    /**
     * @return string
     */
    public function getNetworkCommand()
    {
        return 'merkleblock';
    }

    /**
     * @return FilteredBlock
     */
    public function getFilteredBlock()
    {
        return $this->merkle;
    }

    /**
     * @return \BitWasp\Buffertools\Buffer
     */
    public function getBuffer()
    {
        return (new MerkleBlockSerializer(new FilteredBlockSerializer(new HexBlockHeaderSerializer(), new PartialMerkleTreeSerializer())))->serialize($this);
    }
}
