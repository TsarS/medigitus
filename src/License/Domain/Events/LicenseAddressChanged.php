<?php
declare(strict_types=1);

namespace License\Domain\Events;


use License\Domain\VO\Id;

final class LicenseAddressChanged
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