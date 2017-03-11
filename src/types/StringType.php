<?php
    namespace Milantex\TPC\Types;
    
    use Milantex\TPC\TypeInterface;

    class StringType implements TypeInterface {
        private $pattern = '/^.*$/';
        # private $length = NULL;
        # private $maxLength = \PHP_MAX_INT;

        public function __construct(\stdClass $tags) {
            if (\property_exists($tags, 'pattern')) {
                $this->pattern = $tags->pattern;
            }

            # if (\property_exists($tags, 'length') && \is_int($tags->length)) {
            #    $this->length = $tags->length;
            #}

            #if (\property_exists($tags, 'max_length') && \is_int($tags->max_length)) {
            #    $this->maxLength = $tags->max_lengths;
            #}
        }

        public function isValid($value) : bool {
            if (!\is_string($value)) {
                return false;
            }

            #if ($this->length != NULL && \strlen($value) != $this->length) {
            #    return false;
            #}

            #if (\strlen($value) > $this->maxLength) {
            #    return false;
            #}

            return \boolval(@\preg_match($this->pattern, $value));
        }
    }
