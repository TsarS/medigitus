<?php
declare(strict_types=1);

namespace Clinic\Domain\Events;


use Clinic\Domain\VO\Id;

final class ClinicCreated
{
    /**
     * @var Id
     */
    private Id $id;

    public function __construct(Id $id) {
        $this->id = $id;
    }
}