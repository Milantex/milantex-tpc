<?php
    namespace Milantex\TPC\Types;

    use Milantex\TPC\TypeInterface;

    class DateType implements TypeInterface {
        private $dateFormat = 'Y-m-d H:i:s';

        private $min;
        private $max;
        
        private function fromString($value) {
            return \DateTime::createFromFormat($this->dateFormat, $value);
        }
        
        private function isDate($value) {
            if (!\is_string($value)) {
                return false;
            }

            $datetime = $this->fromString($value . ' 00:00:00');
            
            if ($datetime === false) {
                return false;
            }

            $datetimeExpected = $datetime->format('Y-m-d');

            if ($datetimeExpected !== $value) {
                return false;
            }

            return $this->fromString($value . ' 00:00:00') !== false;
        }

        public function __construct(\stdClass $tags) {
            $this->min = $this->fromString("0000-00-00 00:00:00");
            $this->max = $this->fromString("9999-12-31 23:59:59");

            if (\property_exists($tags, 'min') && $this->isDate($tags->min)) {
                $this->min = $this->fromString($tags->min . ' 00:00:00');
            }

            if (\property_exists($tags, 'max') && $this->isDate($tags->max)) {
                $this->max = $this->fromString($tags->max . ' 00:00:00');
            }
        }

        public function isValid($value) : bool {
            if (!$this->isDate($value)) {
                return false;
            }

            $datetime = $this->fromString($value . ' 00:00:00');

            return $this->min <= $datetime && $datetime <= $this->max;
        }
    }
