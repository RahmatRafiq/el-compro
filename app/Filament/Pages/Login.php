<?php

namespace App\Filament\Pages;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\LoginResponse;
use Filament\Pages\Auth\Login as Page;
use Illuminate\Validation\ValidationException;

class Login extends Page
{
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('unique')
                ->label('Username / Email')
                ->required()
                ->autocomplete()
                ->autofocus()
                ->extraAttributes([
                    'tabindex' => 1,
                ]),
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required()
                ->autocomplete()
                ->revealable()
                ->extraAttributes([
                    'tabindex' => 2,
                ]),
            $this->getRememberFormComponent(),
        ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'unique' => $data['unique'],
            'password' => $data['password'],
        ];
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        $credentials = $this->getCredentialsFromFormData($data);

        // Check if the unique field is an email
        if (filter_var($credentials['unique'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['unique'];
            unset($credentials['unique']);
        } else {
            $credentials['username'] = $credentials['unique'];
            unset($credentials['unique']);
        }

        $credentials['password'] = $data['password'];

        if (! Filament::auth()->attempt($credentials, $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.unique' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}
