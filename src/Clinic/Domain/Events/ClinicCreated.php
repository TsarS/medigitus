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
    private string $name;

    public function __construct(Id $id, string $name) {

        $this->id = $id;
        $this->name = $name;
    }
}