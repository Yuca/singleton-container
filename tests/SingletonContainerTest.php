<?php

declare(strict_types=1);

namespace Yuca\SingletonContainer;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use stdClass;
use Throwable;
use Yuca\SingletonContainer\Mocks\ContainerException;
use Yuca\SingletonContainer\Mocks\NotFoundException;

class SingletonContainerTest extends TestCase
{
    /**
     * Mock of decorate container.
     *
     * @var ContainerInterface|MockObject
     */
    protected $decoratedContainerMock;

    /**
     * Evaluated class.
     *
     * @var SingletonContainer
     */
    protected $singletonContainer;

    /**
     * Common test setup. Initializes evalued class an mocks.
     */
    protected function setUp(): void
    {
        $this->decoratedContainerMock = $this->createMock(ContainerInterface::class);

        $this->singletonContainer = new SingletonContainer(
            $this->decoratedContainerMock
        );
    }

    /**
     * Test that get() method returns the entry got
     * from the decorated container upon first invocation.
     */
    public function testFirstGetReturnsEntryGotFromDecoratedContainer()
    {
        $entry = new stdClass();

        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willReturn($entry);

        $result = $this->singletonContainer->get('Interface');

        $this->assertSame($entry, $result);
    }

    /**
     * Test that get() method returns the cached entry
     * after the first invocation.
     */
    public function testGetCachesEntry()
    {
        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willReturn(new stdClass());
        $firstResult = $this->singletonContainer->get('Interface');

        $consecutiveResult = $this->singletonContainer->get('Interface');

        $this->assertSame($firstResult, $consecutiveResult);
    }

    /**
     * Test that get() method throws up ContainerExceptionInterface raised
     * by the decorated container's get() method.
     */
    public function testGetThrowsUpContainerExceptionInterfaceFromDecoratedContainer()
    {
        $exceptionMock = $this->createMock(ContainerException::class);

        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willThrowException($exceptionMock);

        $this->expectException(ContainerException::class);
        $this->singletonContainer->get('Interface');
    }

    /**
     * Test that get() method throws up NotFoundExceptionInterface raised
     * by the decorated container's get() method.
     */
    public function testGetThrowsUpNotFoundExceptionInterfaceFromDecoratedContainer()
    {
        $exceptionMock = $this->createMock(NotFoundException::class);

        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willThrowException($exceptionMock);

        $this->expectException(NotFoundException::class);
        $this->singletonContainer->get('Interface');
    }

    /**
     * Test that has() method returns true for entry
     * available in decorated container.
     */
    public function testHasReturnsTrueForEntryAvailableInDecoratedContainer()
    {
        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('has')
            ->with('Interface')
            ->willReturn(true);

        $result = $this->singletonContainer->has('Interface');
        $this->assertTrue($result);
    }

    /**
     * Test that has() method returns false for entry
     * unavailable in decorated container.
     */
    public function testHasReturnsFalseForEntryUnavailableInDecoratedContainer()
    {
        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('has')
            ->with('Interface')
            ->willReturn(false);

        $result = $this->singletonContainer->has('Interface');
        $this->assertFalse($result);
    }

    /**
     * Test that isCached() method returns true for got entry.
     */
    public function testIsCachedReturnsTrueForGotEntry()
    {
        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willReturn(new stdClass());
        $this->singletonContainer->get('Interface');

        $result = $this->singletonContainer->isCached('Interface');
        $this->assertTrue($result);
    }

    /**
     * Test that isCached() method returns false for entry which is not got.
     */
    public function testIsCachedReturnsFalseForNotGotEntry()
    {
        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willReturn(new stdClass());
        $this->singletonContainer->get('Interface');

        $result = $this->singletonContainer->isCached('OtherInterface');
        $this->assertFalse($result);
    }

    /**
     * Test that clear() method doesn't throw an exception for an entry
     * which hasn't been got.
     */
    public function testClearSucceedsForNotGotEntry()
    {
        $this->singletonContainer->clear('Interface');
        $this->expectNotToPerformAssertions();
    }

    /**
     * Test that clear() method doesn't throw an exception for an entry
     * which has been got.
     */
    public function testClearSucceedsForGotEntry()
    {
        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willReturn(new stdClass());
        $this->singletonContainer->get('Interface');

        $this->singletonContainer->clear('Interface');
    }

    /**
     * Test that get() method returns the new entry got
     * from the decorated container after the cached one has been cleared.
     */
    public function testGetReturnsNewEntryFromDecoratoredContainerAfterClearing()
    {
        $firstEntry = new stdClass();
        $secondEntry = new stdClass();

        $this->decoratedContainerMock
            ->expects($this->at(0))
            ->method('get')
            ->with('Interface')
            ->willReturn($firstEntry);
        $this->decoratedContainerMock
            ->expects($this->at(1))
            ->method('get')
            ->with('Interface')
            ->willReturn($secondEntry);

        $this->singletonContainer->get('Interface');
        $this->singletonContainer->clear('Interface');
        $result =  $this->singletonContainer->get('Interface');

        $this->assertSame($secondEntry, $result);
    }

    /**
     * Test that isCached() method returns false after
     * the previously got entry has been cleared.
     */
    public function testIsCachedReturnsFalseAfterClearing()
    {
        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willReturn(new stdClass());

        $this->singletonContainer->get('Interface');
        $this->singletonContainer->clear('Interface');
        $result =  $this->singletonContainer->isCached('Interface');

        $this->assertFalse($result);
    }

    /**
     * Test that clearAll() method doesn't throw an exception
     * when no entries are cached.
     */
    public function testClearAllSucceedsForUncachedInstances()
    {
        $this->singletonContainer->clearAll();
        $this->expectNotToPerformAssertions();
    }

    /**
     * Test that clearAll() method doesn't throw an exception
     * when no entries are cached.
     */
    public function testClearAllSucceedsWithCachedInstances()
    {
        $entry = new stdClass();

        $this->decoratedContainerMock
            ->expects($this->once())
            ->method('get')
            ->with('Interface')
            ->willReturn($entry);
        $this->singletonContainer->get('Interface');

        $this->singletonContainer->clearAll();
    }

    /**
     * Test that get() method returns the new entry got
     * from the decorated container after all entries have been cleared.
     */
    public function testGetReturnsNewEntryFromDecoratoredContainerAfterClearingAll()
    {
        $firstEntry = new stdClass();
        $secondEntry = new stdClass();

        $this->decoratedContainerMock
            ->expects($this->at(0))
            ->method('get')
            ->with('Interface')
            ->willReturn($firstEntry);
        $this->decoratedContainerMock
            ->expects($this->at(1))
            ->method('get')
            ->with('Interface')
            ->willReturn($secondEntry);

        $this->singletonContainer->get('Interface');
        $this->singletonContainer->clearAll();
        $result =  $this->singletonContainer->get('Interface');

        $this->assertSame($secondEntry, $result);
    }
}
