<?php

namespace Tests\Feature;

use Tests\TestCase;

class FetchAppCmdTest extends TestCase
{
    public function test_command_handles_invalid_id()
    {
        $this->artisan('app:fetch 999999')
             ->expectsOutput('App not found')
             ->assertExitCode(0);
    }
}
