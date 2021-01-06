<?php
declare(strict_types=1);

namespace Direction\Domain\Entity;



use DateTimeImmutable;
use Direction\Domain\Events\DirectionCreated;
use Direction\Domain\Events\DirectionRenamed;
use Direction\Domain\VO\Id;

final class Direction implements AggregateRoot
{
    use EventTrait;

    /**
     * @var Id
     */
    private Id $id;
    private string $name;
    private DateTimeImmutable $date;

    public function __construct(
      Id $id,
      string $name,
      DateTimeImmutable $date
  ) {

        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->recordEvent(new DirectionCreated($this->id, $this->name));
    }


    /** Удаляет направление из списка

     */
    public function remove(): void
    {
        $this->recordEvent(new DirectionRenamed($this->id, $this->name));
    }

    /** Переименовывает название направления
     * @param string $newName
     */
    public function rename(string $newName): void {
        $this->name = $newName;
        $this->recordEvent(new DirectionRenamed($this->id, $this->name));
    }


    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}