<?php

declare(strict_types=1);

namespace Yuca\SingletonContainer\Mocks;

use Psr\Container\ContainerExceptionInterface;
use Exception;

class ContainerException extends Exception implements ContainerExceptionInterface
{
}
