<?php

namespace Martha\Core\Persistence\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Martha\Core\Domain\Entity\Build;
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

    /**
     * Restart a build.
     *
     * @param int $buildId
     */
    public function restartBuild($buildId)
    {
        $build = $this->getById($buildId);
        $build->setStatus(Build::STATUS_PENDING);
        $build->setSteps(new ArrayCollection());

        $this->flush();
    }
}
