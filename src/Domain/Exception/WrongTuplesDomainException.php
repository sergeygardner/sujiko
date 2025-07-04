<?php

namespace App\Domain\Exception;

use DomainException;

class WrongTuplesDomainException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Wrong tuples");
    }
}
