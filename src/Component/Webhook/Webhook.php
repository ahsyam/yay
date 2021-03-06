<?php

namespace Component\Webhook;

use Component\Webhook\Incoming\ProcessorCollection as IncomingProcessorCollection;
use Component\Webhook\Outgoing\ProcessorCollection as OutgoingProcessorCollection;

class Webhook
{
    /** @var IncomingProcessorCollection */
    protected $incomingProcessors;

    /** @var OutgoingProcessorCollection */
    protected $outgoingProcessors;

    public function __construct(
        IncomingProcessorCollection $incomingProcessors,
        OutgoingProcessorCollection $outgoingProcessors
    ) {
        $this->incomingProcessors = $incomingProcessors;
        $this->outgoingProcessors = $outgoingProcessors;
    }

    public function getIncomingProcessors(): IncomingProcessorCollection
    {
        return $this->incomingProcessors;
    }

    public function getOutgoingProcessors(): OutgoingProcessorCollection
    {
        return $this->outgoingProcessors;
    }
}
