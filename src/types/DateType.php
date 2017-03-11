<?php
    namespace Milantex\TPC\Types;

    use Milantex\TPC\TypeInterface;

    class DateType implements TypeInterface {
        private $dateFormat = 'Y-m-d H:i:s';

        private $min;
        private $max;
        
        private function isDate($value) {
            $datetime = \DateTime::createFromFormat($this->dateFormat, $value . ' 00:00:00');
            
            if ($datetime === false) {
                return false;
            }

            $datetimeExpected = $datetime->format('Y-m-d');

            if ($datetimeExpected !== $value) {
                return false;
            }

            return \DateTime::createFromFormat($this->dateFormat, $value . ' 00:00:00') !== false;
        }

        public function __construct(\stdClass $tags) {
            $this->min = \DateTime::createFromFormat($this->dateFormat, "0000-00-00 00:00:00");
            $this->max = \DateTime::createFromFormat($this->dateFormat, "9999-12-31 23:59:59");

            if (\property_exists($tags, 'min') && $this->isDate($tags->min)) {
                $this->min = \DateTime::createFromFormat($this->dateFormat, $tags->min . ' 00:00:00');
            }

            if (\property_exists($tags, 'max') && $this->isDate($tags->max)) {
                $this->max = \DateTime::createFromFormat($this->dateFormat, $tags->max . ' 00:00:00');
            }
        }

        public function isValid($value) : bool {
            if (!$this->isDate($value)) {
                return false;
            }

            $datetime = \DateTime::createFromFormat($this->dateFormat, $value . ' 00:00:00');

            return $this->min <= $datetime && $datetime <= $this->max;
        }
    }
