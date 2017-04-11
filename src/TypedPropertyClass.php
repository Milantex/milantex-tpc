<?php
    namespace Milantex\TPC;

    class TypedPropertyClass {
        /**
         * @type Milantex\TPC\Types\IntType
         * @min 1900
         */
        private $propertyForTestingPurposesOnly = '1988';
        private $propertyForTestingPurposesOnlyWithoutAnnotations = NULL;

        private final function getPropertyComment(string $name) {
            $reflector = new \ReflectionClass($this);

            if (!$reflector->hasProperty($name)) {
                return '';
            }

            $comments = $reflector->getProperty($name)->getDocComment();

            if ($comments === FALSE) {
                return '';
            }

            return \trim($comments);
        }

        private final function extractPropertyTags(string $comments) {
            $tags = [];
            $matches = [];
            \preg_match_all('/^\\s*\*\\s*@([a-z_]+) +(.*)\\s*$/m', $comments, $matches);

            for ($i=0; $i<\count($matches[0]); $i++) {
                $tags[$matches[1][$i]] = trim($matches[2][$i]);
            }

            return (object) $tags;
        }

        private final function getTypeClassName(\stdClass $tags) {
            $defaultType = 'Milantex\\TPC\\Types\\StringType';

            $type = $defaultType;

            if (\property_exists($tags, 'type') && \is_string($tags->type)) {
                $type = trim($tags->type);
            }

            if (\in_array('Milantex\\TPC\\TypeInterface', \class_implements($type))) {
                return $type;
            }

            return $defaultType;
        }

        private final function getPropertyValueChecker(string $name) {
            $comments = $this->getPropertyComment($name);
            $tags = $this->extractPropertyTags($comments);
            $className = $this->getTypeClassName($tags);
            return new $className($tags);
        }

        protected final function setProperty(string $name, $value) : TypedPropertyClass {
            $checker = $this->getPropertyValueChecker($name);

            if ($checker->isValid($value)) {
                $this->$name = $value;
            }

            return $this;
        }
    }
