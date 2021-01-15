<?php
declare(strict_types=1);

namespace Import\Application\Command\CreateLicense;


use Import\Application\Command\CommandInterface;

final class CreateLicenseCommand implements CommandInterface
{
    private string $inn;
    private string $post_address;
    private array $works;


    public function __construct(
        string $inn,
        string $post_address,
        array $works
    )
    {

        $this->inn = $inn;
        $this->post_address = $post_address;
        $this->works = $works;

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


}