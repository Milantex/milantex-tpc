<?php
    namespace Milantex\TPC\Tests;

    use Milantex\TPC\Types\DateType;

    class DateTypeTest extends \PHPUnit_Framework_TestCase {
        protected $instance;

        public function setUp() {
            $tags = (object) [
                'min' => '1988-03-24',
                'max' => '2017-04-06'
            ];

            $this->instance = new DateType($tags);
        }
        
        public function testIsValid() {
            $this->assertFalse($this->instance->isValid([]));
            $this->assertFalse($this->instance->isValid((object) []));
            $this->assertFalse($this->instance->isValid($this->instance));
            $this->assertFalse($this->instance->isValid('String'));
            $this->assertFalse($this->instance->isValid(3.1415));
            $this->assertFalse($this->instance->isValid(3041));

            $this->assertTrue($this->instance->isValid('2010-10-01'));

            $this->assertFalse($this->instance->isValid('2019-08-08'));
            $this->assertFalse($this->instance->isValid('1789-05-05'));
            $this->assertFalse($this->instance->isValid('2000-56-83'));
        }
    }
