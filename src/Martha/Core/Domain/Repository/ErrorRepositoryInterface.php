<?php

namespace Martha\Core\Domain\Repository;

/**
 * Class ErrorRepository
 * @package Martha\Core\Domain\Repository
 */
interface ErrorRepositoryInterface extends RepositoryInterface
{
    /**
     * @return $this
     */
    public function clearUnreadErrors();

    /**
     * @return $this
     */
    public function deleteAll();
}
