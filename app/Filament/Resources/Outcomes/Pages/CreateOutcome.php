<?php

namespace App\Filament\Resources\Outcomes\Pages;

use App\Filament\Resources\Outcomes\OutcomeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOutcome extends CreateRecord
{
    protected static string $resource = OutcomeResource::class;

    public function getredirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
