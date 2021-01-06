<?php
declare(strict_types=1);

namespace Legal\Domain\Events;


use Legal\Domain\VO\Id;
use Legal\Domain\VO\Inn;

final class LegalCreated
{
    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var Inn
     */
    private Inn $inn;

    public function __construct(Id $id, Inn $inn)
  {
      $this->id = $id;
      $this->inn = $inn;
  }
}