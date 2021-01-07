<?php
declare(strict_types=1);

namespace Clinic\Domain\Repository;


use Clinic\Domain\Entity\Clinic;
use Clinic\Domain\VO\Id;


interface ClinicReadRepository
{
    public function get(Id $id): Clinic;
    public function ifExistByInnAndAddress(string $inn, string $post_code,string $city, string $street,string $building): bool;
}