<?php
declare(strict_types=1);

namespace Direction\Domain\Repository;


use Direction\Domain\Entity\Direction;
use Direction\Domain\VO\Id;


interface DirectionRepository
{
   public function add(Direction $direction): void;
   public function save(Direction $direction): void;
   public function delete(string $id): void;
}