<?php

namespace BCLib\LibraryH3lp;

/**
 * A LibraryH3lp chat queue
 *
 * See https://dev.libraryh3lp.com/presence.html for questions about the LibraryH3lp API and
 * presences.
 *
 * @package BCLib\LibraryH3lp
 */
class Queue
{
    /** @var string */
    private $code;

    /** @var string */
    private $title;

    /**@var string */
    private $skin;

    /** @var bool */
    private $sounds;

    /**
     * Queue constructor.
     *
     * @param string $code queue code
     * @param string $title queue title
     * @param string $skin widget skin ID
     * @param bool $sounds enable sounds by default?
     */
    public function __construct(string $code, string $title, string $skin = null, bool $sounds = false)
    {
        $this->code = $code;
        $this->title = $title;
        $this->skin = $skin;
        $this->sounds = $sounds;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get the URI for the queue
     *
     * Use this to build links to chat windows.
     *
     * @return string the URI
     */
    public function getUri(): string
    {
        $base = "https://libraryh3lp.com/chat/{$this->code}@chat.libraryh3lp.com";
        $params = [
            'title' => $this->title
        ];
        if ($this->skin) {
            $params['skin'] = $this->skin;
        }
        if ($this->sounds) {
            $params['sounds'] = 1;
        }
        return $base . '?' . http_build_query($params);
    }

    /**
     * Is anyone online
     *
     * @return bool anyone home?
     */
    public function isAvailable(): bool
    {
        $doc = new \DOMDocument();
        $doc->load("http://libraryh3lp.com/presence/jid/{$this->code}/chat.libraryh3lp.com/xml");

        $resources = $doc->getElementsByTagName('resource');

        if ($resources->length <= 0) {
            return false;
        }

        return $resources->item(0)->getAttribute('show') === 'available';
    }
}