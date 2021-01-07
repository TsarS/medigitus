<?php
declare(strict_types=1);

namespace Legal\Domain\Repository;


use Legal\Domain\Entity\Legal;
use Legal\Domain\VO\Id;

interface LegalReadRepository
{
    public function get(Id $id): Legal;

    public function existsByInn($inn): bool;
}