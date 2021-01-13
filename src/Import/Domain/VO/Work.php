<?php
declare(strict_types=1);

namespace Import\Domain\VO;


final class Work
{
    private string $work;

    public function __construct(
      string $work
  )
  {
      $this->work = $work;
  }

    /**
     * @return string
     */
    public function getWork(): string
    {
        return $this->work;
    }
}