<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\Overtime;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class, 5)->create()->each(function ($company) {
            factory(User::class, rand(0, 10))
                ->make()
                ->each(function ($user, $key) use ($company) {
                    if ($key === 0) {
                        $user->manager = 1;
                    } else {
                        $user->manager = 0;
                    }
                    $user->company()->associate($company->id)->save();
                    factory(Overtime::class, rand(0, 10))->make()->each(function ($overtime) use ($user) {
                       $user->overtimes()->save($overtime);
                    });
                });
        });

        $user = User::make([
            'first_name' => 'Dennis',
            'last_name' => 'lindeboom',
            'password' => 'password',
            'email' => 'dlindeboom19@outlook.com',
            'manager' => 1
        ])->company()->associate(1);
        $user->save();
        factory(Overtime::class, rand(0, 10))->make()->each(function ($overtime) use ($user) {
            $user->overtimes()->save($overtime);
        });
    }
}
