<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TestExample extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertDatabaseHas('users', ['email' => 'utilisateur@example.com']);
    }
}
