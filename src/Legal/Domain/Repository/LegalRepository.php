<?php
declare(strict_types=1);

namespace Legal\Domain\Repository;


use Legal\Domain\Entity\Legal;

interface LegalRepository
{
    public function add(Legal $legal): void;
    public function save(Legal $legal): void;
}