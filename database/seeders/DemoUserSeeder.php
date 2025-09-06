<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branchData =  Branch::where("is_main_branch",1)->first();
        // dd($branchData);
        // $demoUser = User::create([
        //     'name' => 'مدير النظام',
        //     'username' => 'admin',
        //     'email' => 'admin@alfaseel.com',
        //     'branch_id'=>$branchData->id,
        //     'password' => Hash::make('Admin@123987'),
        //     'remember_token' => Str::random(10)
        // ]);

        // $demoUser->assignRole('admin');

        // $users = config('initiation-data.users');

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $users = config($initiationDataPath.'.users');
        //
        foreach ($users as $user) {
            if(isset($user['password']) && $user['password']){
                $password = Hash::make($user['password']);
            }else{
                $password = Hash::make($user['username']."@Alfaseel");
            }
            $userData = User::create([
                'name' => $user['name'] ,
                'username' => $user['username'],
                'email' => $user['email'],
                'branch_id' => $branchData->id, 
                'password' =>  $password,
                'remember_token' => null
            ]);
            if(isset($user['role']) && $user['role']){
                $userData->assignRole($user['role']);
            }
        }


    }
}

?>