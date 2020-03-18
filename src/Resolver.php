<?php

namespace BCLib\LibraryH3lp;

use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Determines which LibraryH3lp queue to use
 *
 * @package BCLib\LibraryH3lp
 */
class Resolver
{
    /** @var Queue[] */
    private $queues;

    /**
     * Resolver constructor.
     * @param array $queues LibraryH3lp queues, ordered by preference
     */
    public function __construct(array $queues = [])
    {
        $this->queues = $queues;
    }

    /**
     * Add a queue to the end of the list
     *
     * @param Queue $queue
     */
    public function addQueue(Queue $queue): void
    {
        $this->queues[] = $queue;
    }

    /**
     * Get the best URL from the queue
     *
     * Given a list of chat queues ordered by preference, choose the first available queue and return
     * its URL.
     *
     * @return string
     * @throws NoAvailableQueueException
     */
    public function resolve(): string
    {
        foreach ($this->queues as $queue) {
            $url = $queue->getUri();
            if ($queue->isAvailable()) {
                return $url;
            }
        }
        throw new NoAvailableQueueException('Could not find available LibraryH3lp queue');
    }

    /**
     * Figure out the appropriate chat URL and redirect to it
     *
     * @throws NoAvailableQueueException
     */
    public function redirect(): void
    {
        $url = $this->resolve();
        header('HTTP/1.1 303 See Other');
        header("Location: $url");
    }
}