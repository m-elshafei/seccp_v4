<?php

namespace App\View\Components\Report;

use App\Models\WorkType;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ElectricOperationFilter extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        // $workOrdersType = $this->handleFilterListArray(WorkType::pluck('name', 'id')->prepend("اختر","")->toArray());
        $m = WorkType::pluck('name', 'id')->prepend('اختر', '')->toArray();

        // dd($m);
        // $this->workOrdersType=$m;
        return view('components.report.electric-operation-filter')->with('m', $m);
    }

    public function handleFilterListArray($myArray)
    {
        return $result = array_combine(
            array_map(function ($key, $value) {
                if ($value != 'اختر') {
                    return $key.'||'.$value;
                }
            }, array_keys($myArray), $myArray),
            array_values($myArray)
        );
    }
}
