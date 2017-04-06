<?php
    namespace Milantex\TPC\Tests;
    
    require_once '../vendor/autoload.php';
    
    use Milantex\TPC\Types\FloatType;

    class FloatTypeTest extends \PHPUnit_Framework_TestCase {
        protected $instance;

        public function setUp() {
            $tags = (object) [
                'min' => -100.34,
                'max' => 20.23
            ];

            $this->instance = new FloatType($tags);
        }
        
        public function testIsValid() {
            $this->assertFalse($this->instance->isValid([]));
            $this->assertFalse($this->instance->isValid((object) []));
            $this->assertFalse($this->instance->isValid($this->instance));
            $this->assertFalse($this->instance->isValid('String'));

            $this->assertTrue($this->instance->isValid(10.5));
            $this->assertTrue($this->instance->isValid(-100.34));

            $this->assertFalse($this->instance->isValid(-400.10));
            $this->assertFalse($this->instance->isValid(-400));
            $this->assertFalse($this->instance->isValid(29.12));
            $this->assertFalse($this->instance->isValid(21));
        }
    }
