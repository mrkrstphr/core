<?php

namespace Martha\Core\Persistence\Repository;

use Martha\Core\Domain\Repository\ErrorRepositoryInterface;

/**
 * Class ErrorRepository
 * @package Martha\Core\Persistence\Repository
 */
class ErrorRepository extends AbstractRepository implements ErrorRepositoryInterface
{
    /**
     * @var string
     */
    protected $entityType = '\Martha\Core\Domain\Entity\Error';

    /**
     * {@inheritDoc}
     */
    public function clearUnreadErrors()
    {
        $dql = 'UPDATE Martha\Core\Domain\Entity\Error e SET e.wasRead = true WHERE e.wasRead = false';
        $this->entityManager->createQuery($dql)->execute();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteAll()
    {
        $dql = 'DELETE FROM Martha\Core\Domain\Entity\Error e';
        $this->entityManager->createQuery($dql)->execute();

        return $this;
    }
}
