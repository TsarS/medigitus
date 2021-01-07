<?php
declare(strict_types=1);

namespace Clinic\Domain\Events;

use Clinic\Domain\VO\Id;

/**
 * Событие переименования клиники
 * Class ClinicRenamed
 * @package Clinic\Domain\Events
 */
final class ClinicRenamed
{
    /**
     * @var Id
     */
    private Id $id;
    public function __construct(Id $id) {
        $this->id = $id;
    }
}