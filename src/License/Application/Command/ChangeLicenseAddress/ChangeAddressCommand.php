<?php
declare(strict_types=1);

namespace License\Application\Command\ChangeLicenseAddress;


use Import\Application\Command\CommandInterface;

final class ChangeAddressCommand implements CommandInterface
{

    private string $id;

    public function __construct(
        string $id
   )
   {
       $this->id = $id;
   }



    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}