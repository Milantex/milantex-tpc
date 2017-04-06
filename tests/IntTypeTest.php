<?php
    namespace Milantex\TPC\Tests;

    use Milantex\TPC\Types\IntType;

    class IntTypeTest extends \PHPUnit_Framework_TestCase {
        protected $instance;

        public function setUp() {
            $tags = (object) [
                'min' => -3000,
                'max' => 2100
            ];

            $this->instance = new IntType($tags);
        }
        
        public function testIsValid() {
            $this->assertFalse($this->instance->isValid([]));
            $this->assertFalse($this->instance->isValid((object) []));
            $this->assertFalse($this->instance->isValid($this->instance));
            $this->assertFalse($this->instance->isValid('String'));
            $this->assertFalse($this->instance->isValid(3.1415));

            $this->assertTrue($this->instance->isValid(1988));
            $this->assertTrue($this->instance->isValid(0));
            $this->assertTrue($this->instance->isValid(-2301));

            $this->assertFalse($this->instance->isValid(-4000));
            $this->assertFalse($this->instance->isValid(3000));
        }
    }
