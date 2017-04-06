<?php
    namespace Milantex\TPC\Types;
    
    use Milantex\TPC\TypeInterface;

    class FloatType implements TypeInterface {
        private $min = \PHP_INT_MIN; # PHP_FLOAT_MIN will be available 7.2+
        private $max = \PHP_INT_MAX; # PHP_FLOAT_MAX will be available 7.2+

        public function __construct(\stdClass $tags) {
            if (\property_exists($tags, 'min') && \is_double($tags->min)) {
                $this->min = $tags->min;
            }

            if (\property_exists($tags, 'max') && \is_double($tags->max)) {
                $this->max = $tags->max;
            }
        }

        public function isValid($value) : bool {
            if (!\is_double($value)) {
                return false;
            }

            return $this->min <= $value && $value <= $this->max;
        }
    }
