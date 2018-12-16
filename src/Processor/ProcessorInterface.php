<?php

namespace KuwashiroBuster\Processor;

interface ProcessorInterface
{
    public function toChakabunaiOndo($temperature, $coverType);

    public function toYukoSekisanOndo($chakabunaiTemperature, $generation);
}