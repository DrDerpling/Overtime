<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;

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
                });
        });
    }
}
