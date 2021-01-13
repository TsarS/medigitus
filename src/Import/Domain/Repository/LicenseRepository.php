<?php
declare(strict_types=1);

namespace Import\Domain\Repository;


use Import\Domain\Entity\License;

interface LicenseRepository
{
    public function add(License $license);

    public function save(License $license);
}