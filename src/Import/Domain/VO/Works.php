<?php
declare(strict_types=1);

namespace Import\Domain\VO;

use Import\Domain\Exception\WorkCantBeEmptyException;


final class Works
{
    private array $works = [];

    public function __construct(array $works)
    {
        if (!$works) throw new WorkCantBeEmptyException($works);
        foreach ($works as $work) {
            $this->add($work);
        }
    }
    public function add(Work $work): void    {

        foreach ($this->works as $item) {
            if ($item->isEqualTo($work)) {
                return;
            }
        }
        $this->works[] = $work;
    }
    public function getAll(): array
    {
        return $this->works;
    }
}