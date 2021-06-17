<?php

namespace Tests\Unit;

use Tests\TestCase;

class BusinessTest extends TestCase
{
    /**
     * Attempts to test create a category with valid data.
     * 
     * @test
     * 
     * @return void
     */
    public function createCategory_with_valid_data_test()
    {
        $response = $this->postJson("/api/business/createCategory", [
            "nameCategory" => "Test",
        ]);
        $response->assertJsonStructure([
            "message"    
        ]);
    }

    /**
     * Attempts to test register a business with invalid data.
     * 
     * @test
     * 
     * @return void
     */

   public function registerBusiness_with_invalid_data_test()
    {
        $response = $this->postJson("/api/business/registerBusiness", [
            'businessName' => 'Test',
            'businessDescription' => 'TestDescription',
            'categoryId' => 'test'
        ]);
        $response->assertJsonStructure([
            "message"
        ]);
    }

        /**
     * Attempts to test register a business with valid data.
     * 
     * @test
     * 
     * @return void
     */

   public function registerBusiness_with_valid_data_test()
   {
       $response = $this->postJson("/api/business/registerBusiness", [
           'businessName' => 'Test',
           'businessDescription' => 'TestDescription',
           'categoryId' => '0'
       ]);
       $response->assertJsonStructure([
           "message"
       ]);
   }

   /**
    * Attempts to test create a schedule day with invalid data.
    * 
    * @test
    * 
    * @return void
    */
   public function createScheduleDay_with_invalid_data_test()
   {
       $response = $this->postJson("/api/business/{businessId}/createScheduleDay", [
            'businessId' => 1,
            'attentionDay' => 'test',
            'timetable' => 'TEST'
       ]);
       $response->assertJsonStructure([
           "message"
       ]);
   }

    /**
    * Attempts to test create a schedule day with valid data.
    * 
    * @test
    * 
    * @return void
    */

  public function createScheduleDay_with_valid_data_test()
  {
    $response = $this->postJson("/api/business/{businessId}/createScheduleDays", [
        'businessId' => 1,
        'attentionDay' => 1,
        'timetable' => 1
    ]);
    $response->assertJsonStructure([
        "message"
    ]);
  }

    /**
    * Attempts to test register a phine number with invalid data.
    * 
    * @test
    * 
    * @return void
    */
    public function registerPhoneNumber_with_invalid_data_test()
    {
        $response = $this->postJson("/api/business/{businessId}/registerPhoneNumber", [
             'businessId' => 1,
             'phoneNumber' => '0000000',
             'numberType' => 'test'
        ]);
        $response->assertJsonStructure([
            "message"
        ]);
    }
 
    /**
    * Attempts to test register a phone number with valid data.
    * 
    * @test
    * 
    * @return void
    */
 
    public function registerPhoneNumber_with_valid_data_test()
    {
        $response = $this->postJson("/api/business/{businessId}/registerPhoneNumber", [
            'businessId' => 1,
            'phoneNumber' => '0000000',
            'numberType' => 0
        ]);
        $response->assertJsonStructure([
            "message"
        ]);
    }

   /**
    * Attempts to test upload a photo with invalid data.
    * 
    * @test
    * 
    * @return void
    */
    public function uploadPhoto_with_invalid_data_test()
    {
        $response = $this->postJson("/api/business/{businessId}/uploadPhoto", [
             'businessId' => 1,
             'imageStoragePath' => 'Test',
        ]);
        $response->assertJsonStructure([
            "message"
        ]);
    }
}
