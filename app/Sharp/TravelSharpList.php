<?php

namespace App\Sharp;

use App\Models\Passenger;
use App\Models\Travel;
use Code16\Sharp\EntityList\Containers\EntityListDataContainer;
use Code16\Sharp\EntityList\EntityListQueryParams;
use Code16\Sharp\EntityList\SharpEntityList;

class TravelSharpList extends SharpEntityList
{

    function buildListDataContainers(): void
    {
        $this->addDataContainer(
            EntityListDataContainer::make("destination")
                ->setSortable()
                ->setLabel("Destination")
        )->addDataContainer(
            EntityListDataContainer::make("departure_date")
                ->setSortable()
                ->setLabel("Departure date")
        )->addDataContainer(
            EntityListDataContainer::make("spaceship")
                ->setLabel("Spaceship")
        );
    }

    function buildListConfig(): void
    {
        $this//->setSearchable()
            ->setDefaultSort("departure_date", "desc")
            ->setPaginated();
    }

    function buildListLayout(): void
    {
        $this->addColumn("destination", 4)
            ->addColumn("departure_date", 4)
            ->addColumn("spaceship", 4);
    }

    function getListData(EntityListQueryParams $params)
    {
        $travels = Travel::distinct();

        if($params->sortedBy()) {
            $travels->orderBy($params->sortedBy(), $params->sortedDir());
        }

        if ($params->hasSearch()) {
            foreach ($params->searchWords() as $word) {
                $travels->where('destination', 'like', $word);
            }
        }

        return $this
            ->setCustomTransformer("spaceship", function($value, $travel) {
                if(!$travel->spaceship) {
                    return "";
                }
                
                return '<i class="fas fa-space-shuttle"></i> ' . $travel->spaceship->name;
            })
            ->transform($travels->with(["spaceship"])->paginate(30));
    }
}