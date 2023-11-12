<?php

namespace Source\Support;

use Source\Support\Session;

/**
 * Class Message
 * 
 * @package Source\Support
 */
class Message
{
    /** @var string */
    private $text;

    /** @var string */
    private $type;

    /** @var string */
    private $before;

    /** @var string */
    private $after;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string|null
     */
    public function getText(): string|null
    {
        return $this->before . $this->text . $this->after;
    }

    /**
     * @return string|null
     */
    public function getType(): string|null
    {
        return $this->type;
    }

    /**
     * @param string $text
     * 
     * @return Message
     */
    public function before(string $text): Message
    {
        $this->before = $text;
        return $this;
    }

    /**
     * @param string $text
     * 
     * @return Message
     */
    public function after(string $text): Message
    {
        $this->after = $text;
        return $this;
    }

    /**
     * @param string $message
     * 
     * @return Message
     */
    public function info(string $message): Message
    {
        $this->type = 'info';
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * 
     * @return Message
     */
    public function success(string $message): Message
    {
        $this->type = 'success';
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * 
     * @return Message
     */
    public function warning(string $message): Message
    {
        $this->type = 'warning';
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @param string $message
     * 
     * @return Message
     */
    public function error(string $message): Message
    {
        $this->type = 'error';
        $this->text = $this->filter($message);
        return $this;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<script>$.showNotification({type: '{$this->getType()}', message: '{$this->getText()}'});</script>";
    }

    /**
     * @return void
     */
    public function flash(): void
    {
        (new Session())->set('flash', $this);
    }

    /**
     * @param string $message
     * 
     * @return string
     */
    private function filter(string $message): string
    {
        return htmlspecialchars($message);
    }
}
