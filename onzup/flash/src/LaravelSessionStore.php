<?php
namespace Onzup\Flash;

use Illuminate\Session\Store;

class LaravelSessionStore implements SessionStore
{
    /**
     * @var Store
     */
    private $session;

    /**
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash a message to the session.
     *
     * @param string $name
     * @param mixed  $data
     */
    public function flash($name, $data)
    {
        $this->session->flash($name, $data);
    }
}
