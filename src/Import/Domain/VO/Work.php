<?php
declare(strict_types=1);

namespace Import\Domain\VO;


final class Work
{
    private string $work;
    private string $number;
    private string $date;
    private string $activity_type;

    public function __construct(
        string $work,
        string $number,
        string $date,
        string $activity_type
    )
    {
        $this->work = $work;
        $this->number = $number;
        $this->date = $date;
        $this->activity_type = $activity_type;
    }

    /**
     * @return string
     */
    public function getWork(): string
    {
        return $this->work;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getActivityType(): string
    {
        return $this->activity_type;
    }

    public function isEqualTo(self $work): bool
    {
        return $this->getWork() === $work->getWork();
    }


}