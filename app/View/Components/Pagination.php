<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends Component
{
    public $paginator;
    public $elements;

    public function __construct($paginator)
    {
        $this->paginator = $paginator;
        $this->elements = $this->resolveElements($paginator);
    }

    protected function resolveElements($paginator)
    {
        $window = \Illuminate\Pagination\UrlWindow::make($paginator);
        return array_filter([
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);
    }

    public function render()
    {
        return view('components.pagination');
    }
}