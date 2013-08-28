<?php

namespace MarthaTest\Core\Persistence\Repository;

use Martha\Core\Persistence\Repository\Test\PHPUnit\AbstractRepositoryTest;

/**
 * Class BuildRepositoryTest
 * @package MarthaTest\Core\Persistence\Repository
 */
class BuildRepositoryTest extends AbstractRepositoryTest
{
    /**
     * @var string
     */
    protected $testEntity = '\Martha\Core\Domain\Entity\Build';

    /**
     * @var string
     */
    protected $testRepository = '\Martha\Core\Persistence\Repository\BuildRepository';
}
