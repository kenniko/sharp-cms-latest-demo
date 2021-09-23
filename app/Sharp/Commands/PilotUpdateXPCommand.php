<?php

namespace App\Sharp\Commands;

use App\Models\Pilot;
use Code16\Sharp\EntityList\Commands\EntityCommand;
use Code16\Sharp\EntityList\EntityListQueryParams;

class PilotUpdateXPCommand extends EntityCommand
{
    public function label(): string
    {
        return "Update experience";
    }

    public function description(): string
    {
        return "Add one year to every senior pilot experience.";
    }

    public function execute(EntityListQueryParams $params, array $data = []): array
    {
        Pilot::where("role", "sr")->increment("xp");

        return $this->reload();
    }
}