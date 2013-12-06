<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Repository\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package Martha\Core\Persistence\Repository
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\User';
}
