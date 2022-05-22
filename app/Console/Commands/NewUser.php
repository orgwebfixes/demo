<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class NewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'srtpl:newuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('press any digit listed below');
        $i = 1;
        while ($i) {
            $this->info('--------------------------------------------');
            $this->question('1. Run All Migrations like sentry and other');
            $this->question('2. to create new administrator user');
            $this->question('0. for Exit');
            $ask = $this->ask('What is your ans?');
            switch ($ask) {
                case 0:
                    $this->info('Gud Bye......:P');
                    $i = 0;
                    break;
                case 1:
                    //migrate package
                    $this->call('migrate');
                    break;
                case 2:
                    $first_name = $this->ask('What is your name?');
                    //$last_name = $this->ask('What is your last name?');
                    $email = $this->ask('What is your email?');
                    $password = $this->secret('enter the password?');
                    /*$mobile = $this->ask('What is your mobile number?');*/
                    if ($this->confirm('Are you sure? [yes|no]')) {
                        $this->createUser($first_name, $email, $password/*,$mobile*/);
                        $this->info('New User created Successfully');
                    }
                    break;
                default:
                    break;
            }
        }
    }

    private function createUser($name, $email, $password/*,$mobile*/)
    {
        try {
            // Create the user
            $admin = Sentinel::getUserRepository()->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                //'mobile_no' => $mobile
            ]);
            // Create Activations
            //DB::table('activations')->truncate();
            $code = Activation::create($admin)->code;
            Activation::complete($admin, $code);

            // Create Roles
            $slug = 'administrator';
            $administratorRole = Sentinel::findRoleBySlug($slug);
            if (empty($administratorRole)) {
                $administratorRole = Sentinel::getRoleRepository()->create([
                    'name' => 'Administrator',
                    'slug' => 'administrator',
                    'permissions' => [
                        'users.create' => true,
                        'users.update' => true,
                        'users.view' => true,
                        'users.destroy' => true,
                        'users.profile_view' => true,
                        'users.delete' => true,
                        'users.activeDeactive' => true,
                        'roles.create' => true,
                        'roles.update' => true,
                        'roles.view' => true,
                        'roles.delete' => true,
                        'permission.view' => true,
                        'permission.update' => true,
                        'settings.view' => true,
                        'countries.create' => true,
                        'countries.view' => true,
                        'countries.update' => true,
                        'countries.delete' => true
                    ],
                ]);
            }

            $administratorRole->users()->attach($admin);

            //superuser
            // Find the group using the group id
            //$adminGroup = Sentry::findGroupById(1);
            // Assign the group to the user
            //$user->addGroup($adminGroup);
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $this->error('Login field is required.');
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $this->error('Password field is required.');
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $this->error('User with this login already exists.');
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            $this->error('Group was not found.');
        } catch (\PDOException $e) {
            //\Log::info($e);
            $this->info('User Table Not Found.');
        }
    }
}
