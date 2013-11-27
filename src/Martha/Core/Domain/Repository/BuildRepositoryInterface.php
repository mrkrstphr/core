<?php

namespace Martha\Core\Domain\Repository;

/**
 * Class BuildRepositoryInterface
 * @package Martha\Core\Domain\Repository
 */
interface BuildRepositoryInterface extends RepositoryInterface
{
    /**
     * Restart a build.
     *
     * @param int $buildId
     */
    public function restartBuild($buildId);
}
