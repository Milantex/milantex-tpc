<?php
    namespace Milantex\SampleApp;

    require_once '../../vendor/autoload.php';
    
    use Milantex\TPC\TypedPropertyClass;

    class Student extends TypedPropertyClass {
        /**
         * @type Milantex\TPC\Types\StringType
         * @pattern /^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/
         */
        protected $forename;
        
        /**
         * @type Milantex\TPC\Types\StringType
         * @pattern /^[A-Z][a-z]+(?: [A-Z][a-z]+)*$/
         */
        protected $surname;
        
        /**
         * @type Milantex\TPC\Types\DateType
         * @min 1900-01-01
         */
        protected $birthDay;
        
        /**
         * @type Milantex\TPC\Types\IntType
         * @min 2005000000
         */
        protected $index;
        
        /**
         * @type Milantex\TPC\Types\IntType
         * @min 2005
         */
        protected $yearOfEnrollment;

        public function setForename(string $forename) : Student {
            return $this->setProperty('forename', $forename);
        }

        public function setSurname(string $surname) : Student {
            return $this->setProperty('surname', $surname);
        }

        public function setBirthDay(string $birthDay) : Student {
            return $this->setProperty('birthDay', $birthDay);
        }

        public function setIndex(int $index) : Student {
            return $this->setProperty('index', $index);
        }

        public function setYearOfEnrollment(int $yearOfEnrollment) : Student {
            return $this->setProperty('yearOfEnrollment', $yearOfEnrollment);
        }
    }
