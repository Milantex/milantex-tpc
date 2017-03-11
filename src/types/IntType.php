<?php
    namespace Milantex\TPC\Types;
    
    use Milantex\TPC\TypeInterface;

    class IntType implements TypeInterface {
        private $min = \PHP_INT_MIN;
        private $max = \PHP_INT_MAX;

        public function __construct(\stdClass $tags) {
            if (\property_exists($tags, 'min') && \is_numeric($tags->min)) {
                $this->min = $tags->min;
            }

            if (\property_exists($tags, 'max') && \is_numeric($tags->max)) {
                $this->max = $tags->max;
            }
        }

        public function isValid($value) : bool {
            # is_int and is_long are just way to main-stream :)
            if (!\is_numeric($value) || \is_double($value)) {
                return false;
            }

            return $this->min <= $value && $value <= $this->max;
        }
    }
