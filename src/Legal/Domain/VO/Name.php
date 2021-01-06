<?php
declare(strict_types=1);

namespace Legal\Domain\VO;


use Legal\Domain\Exception\Name\LegalMustHaveNameException;


final class Name
{
    private string $name;

    public function __construct(
     string $name
 )
 {
     if (empty($name)) {
         throw new LegalMustHaveNameException($name);
     }
     $this->name = $name;
 }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}