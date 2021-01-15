<?php
declare(strict_types=1);

namespace Import\Domain\Events;


use Import\Domain\VO\Id;

final class LicenseCreated
{
    /**
     * @var Id
     */
    private Id $id;

    public function __construct(Id $id) {
        $this->id = $id;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }
}