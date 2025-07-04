<?php

namespace App\Domain\Exception;

use DomainException;

class WrongGroupIndexesDomainException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Wrong group indexes");
    }
}
