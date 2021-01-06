<?php
declare(strict_types=1);

namespace Clinic\Domain\Events;


use Clinic\Domain\VO\Id;
use DateTimeImmutable;

final class ClinicReinstated
{
  public function __construct(Id $id, DateTimeImmutable $dateTimeImmutable)
  {
  }
}