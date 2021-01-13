<?php
declare(strict_types=1);

namespace Import\Domain\Entity;


use DateTimeImmutable;
use Import\Domain\VO\Id;
use Import\Domain\VO\Work;
use Import\Domain\VO\Works;

final class License
{
    private string $inn;
    private string $post_address;
    private Works $works;
    /**
     * @var Id
     */
    private Id $id;
    private DateTimeImmutable $created_date;

    public function __construct(
        Id $id,
        string $inn,
        string $post_address,
        array $works,
        DateTimeImmutable $created_date
    )
    {
        $this->inn = $inn;
        $this->post_address = $post_address;
        $this->works = new Works($works);
        $this->id = $id;
        $this->created_date = $created_date;
    }

    public function addWork(Work $work)
    {
       $this->works->add($work);
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @return string
     */
    public function getPostAddress(): string
    {
        return $this->post_address;
    }

    /**
     * @return Works
     */
    public function getWorks(): Works
    {
        return $this->works;
    }


    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->created_date;
    }
}