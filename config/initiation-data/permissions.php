<?php
        $actions = collect(array('index','edit','show','create','delete'));
return [
    '1' => [
        'name'=> 'cmn.districts.index', 
        'guard_name'=> 'web', 
        'system_component_id'=> 3
    ],
    '2' => [
        'name'=> 'cmn.districts.create', 
        'guard_name'=> 'web', 
        'system_component_id'=> 3
    ],
    '3' => [
        'name'=> 'cmn.districts.edit', 
        'guard_name'=> 'web', 
        'system_component_id'=> 3
    ],
    '4' => [
        'name'=> 'cmn.districts.show', 
        'guard_name'=> 'web', 
        'system_component_id'=> 3
    ],
   

    '5' => [
        'name'=> 'cmn.districts.delete', 
        'guard_name'=> 'web', 
        'system_component_id'=> 3
    ],

    '6' => [
        'name'=> 'cmn.cities.index', 
        'guard_name'=> 'web', 
        'system_component_id'=> 4
    ],
    '7' => [
        'name'=> 'cmn.cities.create', 
        'guard_name'=> 'web', 
        'system_component_id'=> 4
    ],
    '8' => [
        'name'=> 'cmn.cities.edit', 
        'guard_name'=> 'web', 
        'system_component_id'=> 4
    ],
 
    '9' => [
        'name'=> 'cmn.cities.show', 
        'guard_name'=> 'web', 
        'system_component_id'=> 4
    ],
   

    '10' => [
        'name'=> 'cmn.cities.delete', 
        'guard_name'=> 'web', 
        'system_component_id'=> 4
    ],
 
];