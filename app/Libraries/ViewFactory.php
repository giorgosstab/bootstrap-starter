<?php

namespace App\Libraries;

use Illuminate\Contracts\View\View;
use Jenssegers\Blade\Blade;

class ViewFactory
{
    protected Blade $blade;

    public function __construct()
    {
        $view_folder = resource_path('views');
        $cache = storage_path('framework/views');

        $this->blade = new Blade($view_folder, $cache);
    }

    public function render($view, $data = []): string
    {
        return $this->blade->render($view, $data);
    }

    public function exists($view): bool
    {
        return $this->blade->exists($view);
    }

    public function make($view, $data = []): View
    {
        return $this->blade->make($view, $data);
    }

    public function share($key, $value)
    {
        return $this->blade->share($key, $value);
    }

    public function engine(): Blade
    {
        return $this->blade;
    }
}