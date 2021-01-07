<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


final class Direction
{
    private string $name;
    private int $ambulance;
    private int $surgery;

    public function __construct(
      string $name,
      int $ambulance,
      int $surgery
  )
  {
      $this->name = $name;
      $this->ambulance = $ambulance;
      $this->surgery = $surgery;
  }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isAmbulance():int
    {
        return $this->ambulance;
    }

    /**
     * @return bool
     */
    public function isSurgery(): int
    {
        return $this->surgery;
    }


    public function isEqualTo(self $direction): bool
    {
        return $this === $direction;
    }

}