<?php

declare(strict_types=1);

namespace Yuca\SingletonContainer\Mocks;

use Psr\Container\NotFoundExceptionInterface;
use Exception;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{
}
