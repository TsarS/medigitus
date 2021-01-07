<?php
declare(strict_types=1);

namespace Clinic\Domain\Events;


use Clinic\Domain\VO\Id;
use DateTimeImmutable;

final class ClinicReinstated
{
    /**
     * @var Id
     */
    private Id $id;
    private DateTimeImmutable $dateTimeImmutable;

    public function __construct(Id $id, DateTimeImmutable $dateTimeImmutable)
  {
      $this->id = $id;
      $this->dateTimeImmutable = $dateTimeImmutable;
  }
}