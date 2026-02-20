<?php

namespace App\View\Composers;

use App\Services\SettingsService;
use App\Services\CartService;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ThemeComposer
{
    public function __construct(
        private SettingsService $settings,
        private CartService $cartService,
        private Request $request
    ) {
    }

    public function compose(View $view): void
    {
        $view->with('themeSettings', $this->settings->themeVars());

        // Also inject cart stats
        $cart = $this->cartService->getOrCreateCart($this->request);
        $view->with('cartStats', $this->cartService->getCartTotals($cart));
    }
}
