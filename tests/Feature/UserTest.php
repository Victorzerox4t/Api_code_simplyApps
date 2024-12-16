<?php
namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test register user success
     */
    public function testRegisterSuccess()
    {
        $this->post('api/users', [
            'name' => 'test',
            'username' => 'vicmend24787483',
            'password' => 'apaajalah',
            'email' => 'vicmend2455@gmail.com',
            'phone' => '08576454321',
            'provinsi' => 'kalimantan utara',
            'kota' => 'serawak',
            'alamat' => 'landak Barat',
            'date_of_birth' => '2001-03-27',
        ])->assertStatus(201)
            ->assertJson([
                "data"=>[
                            'name' => 'test',
                            'username' => 'vicmend24787483',
                            'email' => 'vicmend2455@gmail.com',
                            'phone' => '08576454321',
                            'provinsi' => 'kalimantan utara',
                            'kota' => 'serawak',
                            'alamat' => 'landak Barat',
                            'date_of_birth' => '2001-03-27',

                    ]
            ]);
    }

    public function testRegisterFailed()
    {
        $this->post('api/users', [
            'name' => '',
            'username' => '',
            'password' => '',
            'email' => '',
            'date_of_birth' => '',
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'name' => ["The name field is required."],
                    'username' => ["The username field is required."],
                    'password' => ["The password field is required."],
                    'email' => ["The email field is required."],
                    'date_of_birth' => ["The date of birth field is required."],
                ]
            ]);
    }


    public function testLoginSuccess()
    {
        $user = User::where('username', 'Los')->first();
        $this->assertNotNull($user, 'User dengan username "Los" tidak ditemukan di database.');
        $this->post('api/users/login', [
            'username' => 'Los',
            'password' => 'bruitjak2',
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Wardi',
                    'username' => 'Los',
                    'provinsi' => 'jawa utara',
                    'kota' => 'jogyakarta',
                    'alamat' => 'wonososbo',
                    'phone' => '09032898322',
                    'email' => 'vicmend3@gmail.com',
                    'date_of_birth' => '2000-03-29',
                ]
            ]);
        $user->refresh();
        self::assertNotNull($user->token, 'Token tidak ter-generate setelah login.');
    }


    public function testLoginFailedUsernameNotFound()
    {
        $this->post('/api/users/login', [
            'username' => 'sasa',
            'password' => 'victor123',
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'username' => [
                        'Username or password is wrong'
                    ]
                ]
            ]);
    }

    public function testLoginFailedPasswordNotWrong()
    {
            $this->post('/api/users/login', [
                'username' => 'vicmend24787483',
                'password' => 'blalaldgssgsa',
            ])->assertStatus(401)
                ->assertJson([
                    'errors' => [
                        'username' => [
                            'Username or password is wrong'
                        ]
                    ]
                ]);

    }

    public function testGetSuccess()
    {
        $this->get('/api/users/current', [
            'Authorization' => 'tes',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'ryan',
                'username' => 'santo',
                'kota' => 'Gunungsitoli',
                'alamat' => 'Jakarta Barat',
                'phone' => '0857654321',
                'email' => 'vicmend2@gmail.com',
                'date_of_birth' => '1990-03-25',
            ]
        ]);
    }

    public function testGetFailed()
    {

        $this->get('/api/users/current')->assertStatus(401)->assertJson([
            'errors' => [
                'message' => [
                    'unauthorized'
                ]
            ]
        ]);
    }

    public function testGetInvalid()
    {

        $this->get('/api/users/current', [
            'Authorization' => 'blabla',
        ])->assertStatus(401)->assertJson([
            'errors' => [
                'message' => [
                    'unauthorized'
                ]
            ]
        ]);
    }

    public function testUpdatePasswordSuccess()
    {
        $oldUser = User::where('username', 'santo')->first();

        // Update password
        $this->patch('/api/users/current',
            [
                'password' => 'victor123update',
            ],
            [
                'Authorization' => 'tes',
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'santo',
                    'name' => 'ryan',
                ],
            ]);

        $newUser = User::where('username', 'santo')->first();
        self::assertNotEquals($oldUser->password, $newUser->password);
    }

    public function testUpdateNameSuccess()
    {
        $oldUser = User::where('username', 'santo')->first();

        $this->patch('/api/users/current',
            [
                'name' => 'Drake',
            ],
            [
                'Authorization' => 'tes',
            ])
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'santo',
                    'name' => 'Drake',
                ],
            ]);

        $newUser = User::where('username', 'santo')->first();
        $newUser->refresh();

        self::assertNotEquals($oldUser->name, $newUser->name);
    }

    public function testUpdateFailed()
    {
        $this->patch('/api/users/current',
            [
                'name' => 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb',
            ],
            [
                'Authorization' => 'tes',
            ])
            ->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'name' => [
                        'The name field must not be greater than 100 characters.'
                    ]
                ],
            ]);
    }
    public function testLogoutSuccess()
    {
        $this->delete('/api/users/logout', headers:
            [
                'Authorization' => 'tes',
            ]
        )->assertStatus(200)->assertJson([
            'data' => true
        ]);
        $User = User::where('username', 'santo')->first();
        self::assertNull($User->token);
    }

    public function testLogoutFailed()
    {
        $this->delete('/api/users/logout', headers:
            [
                'Authorization' => 'salah',
            ])->assertStatus(401)->assertJson([
            'errors' => [
                'message' => [
                    'unauthorized'
                ]
            ]
        ]);
    }

    //yang ini headers nya dikirim melalui HTTP
    public function testLogoutFailed2()
    {

        $this->withHeaders([
            'Authorization' => 'salah',
        ])->delete('/api/users/logout')
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'unauthorized'
                    ]
                ]
            ]);
    }
}
