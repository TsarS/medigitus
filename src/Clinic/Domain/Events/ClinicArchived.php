<?php
declare(strict_types=1);

namespace Clinic\Domain\Events;


use Clinic\Domain\VO\Id;
use DateTimeImmutable;

final class ClinicArchived
{
    /**
     * @var Id
     */
    private Id $id;
    private DateTimeImmutable $date;

    public function __construct(Id $id, DateTimeImmutable $date) {

        $this->id = $id;
        $this->date = $date;
    }
}