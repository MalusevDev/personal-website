<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\Roles;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command implements PromptsForMissingInput
{
    protected $signature = 'app:create-user {name} {email} {role}';

    protected $description = 'Create new Application User';

    public function handle(Factory $validatorFactory): int
    {
        $password = password(
            label: 'What will be user\'s password?',
            placeholder: 'password',
            required: true,
            hint: 'Minimum 10 characters.',
        );

        $validator = $validatorFactory->make(
            [
                'name' => $this->argument('name'),
                'email' => $this->argument('email'),
                'password' => $password,
                'role' => $this->argument('role'),
            ],
            [
                'name' => 'required|string|min:2|max:150',
                'email' => 'required|string|email|max:255|min:5|unique:users',
                'role' => 'required|string|exists:roles,name',
                'password' =>
                    (new Password(10))
                        ->uncompromised()
                        ->letters()
                        ->symbols()
                        ->mixedCase()
                        ->numbers(),
            ],
        );

        if ($validator->fails()) {
            $this->error('Check you input: ' . $validator->errors()->first());
            return self::INVALID;
        }

        [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ] = $validator->validated();

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'email_verified_at' => now(),
            ]);

            $user->assignRole($role);

            $this->info('User create with ID ' . $user->id);
            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error('Failed to create new user: ', $e->getMessage());
            return self::FAILURE;
        }
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => fn() => text(
                label: 'User\'s name?',
                placeholder: 'User Name',
                required: true,
            ),
            'email' => fn() => text(
                'User\'s email?',
                placeholder: 'example@example.com',
                required: true,
            ),
            'role' => fn() => text(
                'User\'s role?',
                placeholder: Roles::OWNER,
                required: true,
            ),
        ];
    }
}
