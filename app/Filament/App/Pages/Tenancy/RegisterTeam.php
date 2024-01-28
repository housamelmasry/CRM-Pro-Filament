<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(2048)
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(2048),
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data);

        $team->members()->attach(auth()->user());

        return $team;
    }
}



