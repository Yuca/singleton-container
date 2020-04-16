<?php

declare(strict_types=1);

namespace YucaDoo\SingletonContainer;

use Psr\Container\ContainerInterface;

class SingletonContainer implements ContainerInterface
{
    /**
     * Decorated container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Cached instances.
     *
     * @var array
     */
    private $instances = array();

    /**
     * Constructor.
     *
     * @param ContainerInterface $container Decorated container.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Finds an entry by its identifier and returns it.
     * Searches first amongst cached entries and them in the decorated container.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (!array_key_exists($id, $this->instances)) {
            $this->instances[$id] = $this->container->get($id);
        }
        return $this->instances[$id];
    }

    /**
     * Returns true if the decorated container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id)
    {
        return $this->container->has($id);
    }

    /**
     * Returns true if the entry for the given identifier is already cached.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function isCached($id)
    {
        return array_key_exists($id, $this->instances);
    }

    /**
     * Releases the cached instance for the given identifier if cached.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return void
     */
    public function clear($id)
    {
        unset($this->instances[$id]);
    }

    /**
     * Releases all cached instances. Useful for memory reduction.
     *
     * @return void
     */
    public function clearAll()
    {
        $this->instances = array();
    }
}
