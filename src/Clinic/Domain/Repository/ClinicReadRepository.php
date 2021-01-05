<?php
declare(strict_types=1);

namespace Clinic\Domain\Repository;


use Clinic\Domain\VO\Id;

interface ClinicReadRepository
{
    public function get(Id $id): Clinic;
}