<?php

namespace Motork;

use PHPUnit\Framework\TestCase;

class CarControllerTest extends TestCase {
	
	public function testIsCarController()
	{
	    $this->assertInstanceOf(
	        CarController::class,
	        CarController::create()
        );
	    
	}
	

}