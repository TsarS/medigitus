<?php
declare(strict_types=1);

namespace Import\Domain\Entity;


use DateTimeImmutable;
use Import\Domain\VO\Id;

final class License
{
    private string $inn;
    private string $post_address;
    private array $works;
    private string $number;
    private string $license_date;
    private string $license_type;
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
        $this->works = $works;
        $this->id = $id;
        $this->created_date = $created_date;
    }

    public function addWork($work)
    {
        print_r('addWork'.$work);
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
     * @return array
     */
    public function getWorks(): array
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