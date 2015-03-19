<?php

namespace Framework\Cura\Modules;

abstract class Module
{
    public function getFolderPath() {
        return realpath(__DIR__);
    }
    
    
}
