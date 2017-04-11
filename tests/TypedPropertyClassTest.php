<?php
    namespace Milantex\TPC\Tests;

    use Milantex\TPC\TypedPropertyClass;
    
    class TypedPropertyClassTest extends \PHPUnit_Framework_TestCase {
        private $instance;
        private $tagsWithGoodType;
        private $tagsWithBadType;
        private $classNameFromTagsWithType;
        private $classNameFromTagsWithoutType;

        /**
         * Call protected/private method of a class.
         *
         * @author Juan Treminio <jtreminio@gmail.com>
         * @param object &$object    Instantiated object that we will run method on.
         * @param string $methodName Method name to call
         * @param array  $parameters Array of parameters to pass into method.
         *
         * @return mixed Method return.
         */
        public function invokeMethod(&$object, $methodName, array $parameters = array()) {
            $reflection = new \ReflectionClass(get_class($object));
            $method = $reflection->getMethod($methodName);
            $method->setAccessible(true);
            return $method->invokeArgs($object, $parameters);
        }

        public function setUp() {
            $this->instance = new TypedPropertyClass();
            
            $annotationWithGoodType = '/**
                * @type Milantex\TPC\Types\IntType
                * @min 1900
                */';

            $annotationWithBadType = '/**
                * @type Exception
                * @someRandomTag Value
                */';

            $this->tagsWithGoodType = $this->invokeMethod($this->instance, 'extractPropertyTags', [$annotationWithGoodType]);
            $this->tagsWithBadType = $this->invokeMethod($this->instance, 'extractPropertyTags', [$annotationWithBadType]);
        }

        public function testGetPropertyComment() {
            $this->assertTrue(strlen($this->invokeMethod($this->instance, 'getPropertyComment', ['propertyForTestingPurposesOnly'])) > 0);
            $this->assertTrue(strlen($this->invokeMethod($this->instance, 'getPropertyComment', ['somePropertyThatDoesNotExist'])) == '');
            $this->assertTrue(strlen($this->invokeMethod($this->instance, 'getPropertyComment', ['propertyForTestingPurposesOnlyWithoutAnnotations'])) == '');
        }

        public function testExtractPropertyTags() {
            $this->classNameFromTagsWithGoodType = $this->invokeMethod($this->instance, 'getTypeClassName', [$this->tagsWithGoodType]);

            $this->assertObjectHasAttribute('type', $this->tagsWithGoodType);
            $this->assertObjectHasAttribute('min', $this->tagsWithGoodType);
            $this->assertObjectNotHasAttribute('max', $this->tagsWithGoodType);
        }

        public function testGetTypeClassName() {
            $this->classNameFromTagsWithBadType = $this->invokeMethod($this->instance, 'getTypeClassName', [$this->tagsWithBadType]);

            $this->assertTrue($this->invokeMethod($this->instance, 'getTypeClassName', [$this->tagsWithBadType]) == 'Milantex\\TPC\\Types\\StringType');
            $this->assertFalse($this->invokeMethod($this->instance, 'getTypeClassName', [$this->tagsWithGoodType]) == 'Milantex\\TPC\\Types\\StringType');
        }

        public function testGetPropertyValueChecker() {
            $checker = $this->invokeMethod($this->instance, 'getPropertyValueChecker', ['propertyForTestingPurposesOnly']);
            $this->assertInstanceOf('Milantex\TPC\Types\IntType', $checker);
        }

        public function testSetProperty() {
            $returned = $this->invokeMethod($this->instance, 'setProperty', ['propertyForTestingPurposesOnly', 2009]);
            $this->assertInstanceOf('Milantex\TPC\TypedPropertyClass', $returned);
        }
    }
