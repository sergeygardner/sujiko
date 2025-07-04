<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @extends ArrayCollection<int, MatrixValuesDTOCollection>
 */
class MatrixDTOCollection extends ArrayCollection
{
}
