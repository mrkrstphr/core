<?php

namespace Martha\Core\Authentication\Provider;

use Martha\Core\Http\Request;

/**
 * Class AbstractOAuthProvider
 * @package Martha\Core\Authentication\Provider
 */
abstract class AbstractOAuthProvider extends AbstractProvider
{
    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @return string
     */
    abstract public function getUrl();

    /**
     * @return string
     */
    abstract public function getIcon();

    /**
     * @param \Martha\Core\Http\Request $request
     * @return boolean|\Martha\Core\Domain\Entity\User
     */
    abstract public function validateResult(Request $request);
}
