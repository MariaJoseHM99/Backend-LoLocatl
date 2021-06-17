<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Attempts to test sign up with invalid data.
     * 
     * @test
     * 
     * @return void
     */
    public function signUp_with_invalid_data_test()
    {
        $response = $this->postJson("/api/user/signUp", [
            "name" => "NameTest",
            "lastname" => "123937",
            "email" => "91872",
            "password" => "1",
            "address" => "768.",
            "cellphoneNumber" => ".",
            
            
        ]);
        $response->assertJsonStructure([
            "message",
            "errors"
        ]);
    }

    /**
     * Attempts to test sign up with valid data.
     * 
     * @test
     * 
     * @return void
     */
    public function signUp_with_valid_data_test()
    {
        $response = $this->postJson("/api/user/signUp", [
            "name" => "Test",
            "lastname" => "TestLastname",
            "email" => "emailTest@gmail.com",
            "password" => "passwordTest",
            "address" => "Hacienda los Cafetales",
            "cellphoneNumber" => "2288887766",
        ]);
        $response->assertJsonStructure([
            "message"    
        ]);
    }

    /**
     * Attempts to test log in with invalid data.
     * 
     * @test
     * 
     * @return void
     */
    public function login_with_invalid_data_test()
    {
        $response = $this->postJson("/api/user/login", [

            "email" => "9374",
            "password" => "139838"
        ]);
        $response->assertJsonStructure([
            "message"    
        ]);
    }

    /**
     * Attempts to test log in with a non-existent email registered.
     * 
     * @test
     * 
     * @return void
     */
    public function login_with_non_existent_account_test()
    {
        $response = $this->postJson("/api/user/login", [

            "email" => "test12@gmail.com",
            "password" => "passwordTest"
        ]);
        $response->assertJsonStructure([
            "status",
            "message"    
        ]);
    }

    /**
     * Attempts to test log in with an existent account but,
     * using a wrong password
     * 
     * @test
     * 
     * @return void
     */
    public function login_with_an_existent_account_and_wrong_password_test()
    {
        $response = $this->postJson("/api/user/login", [

            "email" => "emailTest@gmail.com",
            "password" => "password"
        ]);
        $response->assertJsonStructure([
            "status",
            "message"    
        ]);
    }

    /**
     * Attempts to test log in with an existent account
     * 
     * @test
     * 
     * @return void
     */
    /*public function login_with_an_existent_account_test()
    {
        $response = $this->postJson("/api/user/login", [

            "email" => "emailTest@gmail.com",
            "password" => "passwordTest"
        ]);
        $response->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_at"
        ]);
    }*/
}