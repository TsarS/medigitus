<?php
declare(strict_types=1);

namespace License\tests\unit\Application\Middleware;


use License\Application\Middleware\Location;
use PHPUnit\Framework\TestCase;

final class LocationTest extends TestCase
{
  public function testReturnAddressFromLocation() : void {
      $address = 'Москва, Волочаевская, 15 к.1';
      $data = new Location();
      $data->getExtractedData($address);
      $this->assertEquals('Москва',$data->getRegion());
      $this->assertEquals('55.7509485',$data->getLat());
      $this->assertEquals('37.6778102',$data->getLon());
  }
}