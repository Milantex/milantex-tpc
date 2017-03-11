<?php
    namespace Milantex\SampleApp;

    require_once './Student.php';

    $s = new Student();
    $s->setForename('Milan')
      ->setSurname('Tair')
      ->setBirthDay('1988-03-24')
      ->setYearOfEnrollment(2008)
      ->setIndex(2008213514);

    echo '<pre>' . print_r($s, true) . '</pre>';

    # See the definition of the $forename property in the Student class (regex)
    # Since the text above is not a valid forename format, it will not be set
    $s->setForename('Not a valid name');

    echo '<pre>' . print_r($s, true) . '</pre>';

    # Almost all data that follow is valid (forename, surname and birthday),
    # but the year and the index are not. These will not be set to new values.
    $s->setForename('Pera')
      ->setSurname('Peric')
      ->setBirthDay('1991-04-30')
      ->setYearOfEnrollment(208)
      ->setIndex(2083321);

    echo '<pre>' . print_r($s, true) . '</pre>';

    # Tthis time the date will not be set, because it is impossible (May 31st).
    $s->setBirthDay('1991-04-31');

    echo '<pre>' . print_r($s, true) . '</pre>';
