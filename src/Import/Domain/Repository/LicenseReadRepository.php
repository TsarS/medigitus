<?php
declare(strict_types=1);

namespace Import\Domain\Repository;


use Import\Domain\VO\Id;

interface LicenseReadRepository
{
   public function get(Id $id);
   public function getByAddress(string $address);
   public function addressExist(string $address);
}