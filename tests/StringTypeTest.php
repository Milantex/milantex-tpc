<?php
    namespace Milantex\TPC\Tests;

    use Milantex\TPC\Types\StringType;

    class StringTypeTest extends \PHPUnit_Framework_TestCase {
        protected $instance;

        public function setUp() {
            $tags = (object) [
                'pattern' => '/^[A-z]{3,10}$/'
            ];

            $this->instance = new StringType($tags);
        }

        public function testIsValid() {
            $this->assertFalse($this->instance->isValid([]));
            $this->assertFalse($this->instance->isValid((object) []));
            $this->assertFalse($this->instance->isValid($this->instance));
            $this->assertTrue($this->instance->isValid('String'));
            $this->assertFalse($this->instance->isValid('Does not match the pattern'));
        }
    }
