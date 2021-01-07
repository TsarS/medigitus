<?php
declare(strict_types=1);

namespace Direction\Domain\Events;


use Direction\Domain\VO\Id;

final class DirectionRemoved
{
    /**
     * @var Id
     */
    private Id $id;


    public function __construct(Id $id)
  {
      $this->id = $id;
  }
}