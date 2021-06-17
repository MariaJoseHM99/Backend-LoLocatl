<?php

namespace Tests\Unit;

use Tests\TestCase;

class ReviewTest extends TestCase
{
    /**
     * Attempts to add a review to business with invalid data.
     * 
     * @test
     * 
     * @return void
     */
    public function addReviewToBusiness_with_invalid_data_test()
    {
        $response = $this->postJson("/api/business/{businessId}/addReviewToBusiness", [
             'businessId' => 1,
             'comment' => 'Test',
             'star' => 'Test'
        ]);
        $response->assertJsonStructure([
            "message"
        ]);
    }

    /**
     * Attempts to add a review to business with valid data.
     * 
     * @test
     * 
     * @return void
     */
    public function addReviewToBusiness_with_valid_data_test()
    {
        $response = $this->postJson("/api/business/{businessId}/addReviewToBusiness", [
             'businessId' => 1,
             'comment' => 'Test',
             'star' => 4
        ]);
        $response->assertJsonStructure([
            "message"
        ]);
    }
}
