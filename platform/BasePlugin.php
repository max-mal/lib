<?php

namespace platform;

class BasePlugin
{
    protected $version = '1.0';
    public $id = null;

    public function __construct()
    {
        $this->id = $this->getName();
    }

    public function getName()
    {
        return '';
    }

    public function getDescription()
    {
        return '';
    }

    public function getNavigation()
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        return [];
    }
}
