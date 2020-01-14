<?php
declare(strict_types=1);

namespace User\Core\Application\Query;

use User\Core\Application\Exception\UserNotFound;
use User\Core\Application\ReadModel\UserReadModel;

interface UserQuery
{
    /**
     * @param string $id
     * @return UserReadModel
     * @throws UserNotFound
     */
    public function getById(string $id): UserReadModel;
}
