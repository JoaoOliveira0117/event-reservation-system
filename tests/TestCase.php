<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();

        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
        
        Artisan::call('migrate:refresh');
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    public function __get($key) {
    
        if ($key === 'faker')
            return $this->faker;
        throw new \Exception('Unknown Key Requested');
    }

}
