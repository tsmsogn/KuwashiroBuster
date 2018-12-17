<?php

namespace KuwashiroBuster\Processor;

interface ProcessorInterface
{
    public function toChakabunaiOndo($temperature, $coverType);

    public function toHiatariYukoOndo($chakabunaiOndo, $generation);
}