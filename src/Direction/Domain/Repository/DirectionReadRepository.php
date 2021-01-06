<?php
declare(strict_types=1);

namespace Direction\Domain\Repository;


use Direction\Domain\VO\Id;

interface DirectionReadRepository
{
  public function get(Id $id);
}