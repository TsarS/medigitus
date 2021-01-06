<?php
declare(strict_types=1);

namespace Direction\Domain\Repository;


use Direction\Domain\Entity\Direction;

interface DirectionRepository
{
   public function add(Direction $direction): void;
   public function save(Direction $direction): void;
}