<?php
declare(strict_types=1);

namespace Clinic\Domain\VO;


final class Name
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        /*
        if (strpos($name, '"')) {
            $this->removeQuotes($name);
        } else {
            $this->name = $name;
        }
        */
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    private function removeQuotes($name)
    {
        $m = [];
        preg_match('/"([^"]+)"/', $name, $m);
            $this->name = $m[1];
    }


}