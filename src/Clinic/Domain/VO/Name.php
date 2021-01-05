<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


final class Name
{
    private string $name;

    public function __construct(string $name)
  {
      $this->name = $name;
  }
}