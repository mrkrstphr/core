<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Repository\BuildRepositoryInterface;

/**
 * Class BuildRepository
 * @package Martha\Core\Persistence\Repository
 */
class BuildRepository extends AbstractRepository implements BuildRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\Build';
}

