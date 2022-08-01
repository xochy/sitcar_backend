<?php

namespace Tests;

use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MakesJsonApiRequests;
}
