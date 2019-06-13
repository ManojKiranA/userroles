<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @return void
     */

    public function run()
    {
        
        //now we are getting the List of Config Form the useraccess file
        $userTableData = Config::get( 'useraccess.seeders.usersTable');

        $rootUserArrayKey = 'superUserData';

        foreach($userTableData as $userDataName => $userData)
        {
            if ($userDataName === $rootUserArrayKey) 
            {
                $this->command->info(' ');
                $this->command->info(' ');
                $this->command->info('Creating Super User');
                $this->command->info('Email ' . $userData['email']);
                $this->command->info('password ' . $userData['password']);
                $this->command->info('Kindly Copy email and Passsword to login');
                $this->command->info(' ');
                $this->command->info(' ');
                // if($this->command->confirm('Do You Need to Store the SuperAdmin User Password(IN ENCRYPTED FORMAT) in the Storage Path', true))
                // {
                //     $this->command->info('Storing the Password in the encrypted format');
                //     $this->storePassword($userData['password']);
                // }
            }

            User::create($userData);
        }        
    }

    /**
     * Store the Password in the encrypted format
     *
     * @author Manojkiran.A <manojkiran10031998@gmail.com>
     * @param string $password
     **/
    public function storePassword(string $password)
    {
        $text = 'This File Contains the Encrypted form of the Password'.$this->lb(2);
        $text .= 'The Password is Encrypted with the Crypt Facade of the'.$this->lb(2);
        $text .= 'The Password is Encrypted With the Current App key'.$this->lb(2);
        $text .= "So if the APP_KEY is changed you can't be able ot decrypt and retrive the old password".$this->lb(2);
        $text .= "So the You can Decrypt the password By Crypt::decrypt('yourencryptedcontents')".$this->lb(2);
        $text .= "---- Start Password ----".$this->lb(4);
        $text .= Crypt::encrypt($password);
        $text .= $this->lb(3)."---- End Password ----".$this->lb(1);
        $passwordFilePath = storage_path().DIRECTORY_SEPARATOR.Str::slug(Carbon::now()->toDateTimeString()).'.txt';        
        File::put($passwordFilePath,$text);
        $this->command->info($passwordFilePath);
    }

    /**
     * Returns the line break statment
     *
     * @author [A. Manojkiran] [<manojkiran10031998@gmail.com>]
     * @return string    
     * @version      1.1
     */
    public function lb(int $repeat = 1)
    {
        return str_repeat("\n",$repeat);
    }
}