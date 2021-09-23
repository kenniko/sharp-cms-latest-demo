<?php

namespace App\Sharp;

use App\Models\Pilot;
use App\Sharp\CustomFormFields\SharpCustomFormFieldTextIcon;
use App\Models\Spaceship;
use Code16\Sharp\Form\Eloquent\WithSharpFormEloquentUpdater;
use Code16\Sharp\Form\Layout\FormLayoutColumn;
use Code16\Sharp\Form\SharpForm;

class PilotJuniorSharpForm extends SharpForm
{
    use WithSharpFormEloquentUpdater;

    function buildFormFields(): void
    {
        $this->addField(
            SharpCustomFormFieldTextIcon::make("name")
                ->setLabel("Name")
                ->setHelpMessage("This input is an example of a custom form field (SharpCustomFormFieldTextIcon)")
                ->setIcon("fa-user")
        );
    }

    function buildFormLayout(): void
    {
        $this->addColumn(6, function(FormLayoutColumn $column) {
            $column->withSingleField("name");
        });
    }

    function find($id): array
    {
        return $this->transform(Pilot::findOrFail($id));
    }

    function update($id, array $data)
    {
        $pilot = $id ? Pilot::findOrFail($id) : new Pilot;

        $pilot = $this->save($pilot, $data + ["role" => "jr"]);

        if(currentSharpRequest()->isCreation()) {
            if($breadcrumbItem = currentSharpRequest()->getPreviousShowFromBreadcrumbItems()) {
                if ($breadcrumbItem->entityKey() === "spaceship") {
                    Spaceship::findOrFail($breadcrumbItem->instanceId())
                        ->pilots()
                        ->attach($pilot->id);
                }
            }
        }
        
        return $pilot->id;
    }

    function buildFormConfig(): void
    {
        $this->setBreadcrumbCustomLabelAttribute("name");
    }

    function delete($id): void
    {
        Pilot::findOrFail($id)->delete();
    }
}
