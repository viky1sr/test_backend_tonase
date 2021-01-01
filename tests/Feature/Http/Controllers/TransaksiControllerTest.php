<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SaldoUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TransaksiControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_store()
    {



        $user = SaldoUser::where('number_card',20207071997)->first();

        $response = $this->post('/api/top-up-saldo', [
            "card_id" => $user->number_card,
            "amount" =>"150000"
        ]);

        $response->assertStatus(200);
    }
}
