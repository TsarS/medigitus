<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


final class Licence
{
    private string $licence_number;
    private string $licence_date;
    private array $works;

    public function __construct(
        string $licence_number,
        string $licence_date,
        array $works
    )
    {
        $this->licence_number = $licence_number;
        $this->licence_date = $licence_date;
        $this->works = $works;
    }
}