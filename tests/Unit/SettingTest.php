<?php

namespace Tests\Unit;

use Tests\TestCase;

class SettingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSetting()
    {
        $value = [
            'key'  => 'overtime_method',
            'value'=>   2

        ];

        $this->patch('/settings', $value)->assertStatus(201);
    }
}
