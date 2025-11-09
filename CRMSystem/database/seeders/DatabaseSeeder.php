<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Communication;
use App\Models\FollowUp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // إنشاء الأدوار
        Role::firstOrCreate(['name'=>'admin']);
        Role::firstOrCreate(['name'=>'manager']);
        Role::firstOrCreate(['name'=>'sales_rep']);

        // إنشاء مستخدم admin
        $admin = User::firstOrCreate(
            ['email'=>'admin@example.com'],
            ['name'=>'Admin User', 'password'=>Hash::make('password')]
        );
        $admin->assignRole('admin');

        // إنشاء مستخدم manager
        $manager = User::firstOrCreate(
            ['email'=>'manager@example.com'],
            ['name'=>'Manager User', 'password'=>Hash::make('password')]
        );
        $manager->assignRole('manager');

        // إنشاء 5 Sales Reps
        User::factory(5)->create()->each(function($user){
            $user->assignRole('sales_rep');
        });

         $salesReps = User::role('sales_rep')->get();

        Client::factory(20)->make()->each(function($client) use ($salesReps) {
            $client->assigned_to = $salesReps->random()->id;
            $client->save();
        });

        Client::all()->each(function($client){
    Communication::factory(rand(1,5))->make()->each(function($comm) use ($client) {
        $comm->client_id = $client->id;
        $comm->created_by = User::role('sales_rep')->inRandomOrder()->first()->id;
        $comm->save();
            });
        });

        Client::all()->each(function($client){
    FollowUp::factory(rand(0,3))->make()->each(function($follow) use ($client) {
        $follow->client_id = $client->id;
        $follow->user_id = User::role('sales_rep')->inRandomOrder()->first()->id;
        $follow->due_at = now()->addDays(rand(1,10));
        $follow->save();
            });
        });

    }
}
