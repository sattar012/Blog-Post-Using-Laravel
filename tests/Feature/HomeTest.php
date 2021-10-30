<?php

namespace Tests\Feature;


use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertSeeText(' Hello World! ');
        $response->assertSeeText('This is me Larvel Learner');

       
    }
    
    public function testContactpageisworkingcorrectly()

    {

        $response= $this->get('/contact');

        $response->assertSeeText('This is Contact page');

        $response->assertSeeText('Would you like to raise an error');



    }

}
