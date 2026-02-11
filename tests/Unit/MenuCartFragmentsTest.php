<?php

use PHPUnit\Framework\TestCase;
use theme_plugin\components\MenuCart;

final class MenuCartFragmentsTest extends TestCase
{
    public function test_fragments_include_cart_count_and_mini_cart_wrapper(): void
    {
        MenuCart::$template = 'bs-5';
        $GLOBALS['wp_theme_plugin_test_cart_count'] = 2;

        $fragments = MenuCart::add_to_cart_fragments(null);

        $this->assertIsArray($fragments);
        $this->assertArrayHasKey('.cart-count', $fragments);
        $this->assertArrayHasKey('.mini-cart', $fragments);

        $this->assertSame('<span class="cart-count">2</span>', $fragments['.cart-count']);

        $this->assertStringContainsString('class="navbar-nav mini-cart dropdown"', $fragments['.mini-cart']);
        $this->assertStringContainsString('class="cart-count"', $fragments['.mini-cart']);
        $this->assertStringContainsString('dropdown-menu-mini-cart', $fragments['.mini-cart']);
    }

    public function test_fragments_work_with_empty_cart(): void
    {
        MenuCart::$template = 'bs-5';
        $GLOBALS['wp_theme_plugin_test_cart_count'] = 0;

        $fragments = MenuCart::add_to_cart_fragments(null);

        $this->assertIsArray($fragments);
        $this->assertSame('<span class="cart-count">0</span>', $fragments['.cart-count']);
        $this->assertStringContainsString('woocommerce-mini-cart__empty-message', $fragments['.mini-cart']);
    }
}
