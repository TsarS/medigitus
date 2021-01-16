<?php
declare(strict_types=1);

namespace License\Domain\Repository;


use License\Domain\Entity\License;

interface LicenseRepository
{
    public function add(License $license);

    public function updateWorks(License $license);

    public function save(License $license);
}