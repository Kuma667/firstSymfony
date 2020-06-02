<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FilterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('prix', [$this, 'prix']),
        ];
    }

    public function prix($prix, $monnaie)
    {
        return number_format($prix, 2, ',', ' ').' '.$monnaie;
    }
}
