<?php

namespace Domain\Course\Model;

interface TariffInterface
{
    public function getName(): string;

    public function getAmount(): int;
} 