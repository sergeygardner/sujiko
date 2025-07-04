<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @extends ArrayCollection<int, int>
 */
class TupleDTOCollection extends ArrayCollection
{
    public int $sum = 0 {
        get {
            return $this->sum;
        }
        set {
            $this->sum = $value;
        }
    }

}
