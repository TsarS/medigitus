<?php
declare(strict_types=1);

namespace License\Domain\Repository;


use License\Domain\VO\Id;

interface LicenseReadRepository
{
   public function get(Id $id);
   public function getByAddress(string $address);
   public function addressExist(string $address);
}