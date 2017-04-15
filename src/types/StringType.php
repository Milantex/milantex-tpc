<?php
    namespace Milantex\TPC\Types;
    
    use Milantex\TPC\TypeInterface;

    class StringType implements TypeInterface {
        private $pattern = '/^.*$/';

        public function __construct(\stdClass $tags) {
            if (\property_exists($tags, 'pattern')) {
                $this->pattern = $tags->pattern;
            }
        }

        public function isValid($value) : bool {
            if (!\is_string($value)) {
                return false;
            }

            return \boolval(\preg_match($this->pattern, $value));
        }
    }
