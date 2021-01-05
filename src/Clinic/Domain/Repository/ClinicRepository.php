<?php
declare(strict_types=1);

namespace Clinic\Domain\Repository;


use Clinic\Domain\Entity\Clinic;

interface ClinicRepository
{
    public function add(Clinic $clinic): void;
    public function save(Clinic $clinic): void;
}