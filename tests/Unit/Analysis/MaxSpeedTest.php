<?php

declare(strict_types=1);

namespace App\Tests\Unit\Analysis;

use App\Analysis\MaxSpeed;

/**
 * Class MaxSpeedTest.
 */
class MaxSpeedTest extends MetricTestCase
{
    /**
     * Test Max is Returned.
     */
    public function testMaxIsReturned()
    {
        $analysis = new MaxSpeed(self::$dataset);

        $this->assertEquals(101.79, $analysis->result());
    }
}
