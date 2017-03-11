<?php
    namespace Milantex\TPC;

    interface TypeInterface {
        public function __construct(\stdClass $tags);
        public function isValid($value) : bool;
    }
