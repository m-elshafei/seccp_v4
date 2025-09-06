<?php

namespace App\Http\Controllers;

use App\Models\AssayItem;
use Illuminate\Http\Request;
use Flash;

class AssayItemController extends AppBaseController
{
    public function store(Request $request)
    {
        //dd($request->all());
        request()->validate(AssayItem::$rules);

        $input = $request->all();

        $_returned = $input['spend'] - $input['used'];

        //$returned = $_returned >= 0? $_returned : 0;
        if($_returned < 0){
            $returned_spend = $input['used'] - $input['spend'];
            $returned = 0;
        }else{
            $returned_spend =0;
            $returned = $_returned;
        }

        $fillable = [
            'assay_form_id' => $input['assay_form_id'],
            'item_id' => $input['item_id'],
            'spend' => $input['spend'],
            'used' => $input['used'],
            'returned' => $returned,
            'returned_spend' => $returned_spend
        ];

        $result = AssayItem::where([
            'item_id' => $input['item_id'],
            'assay_form_id' => $input['assay_form_id']
        ])->first();

        if ($result){
            $result->fill($fillable);
            $result->save();
        } else {
            $result = AssayItem::create($fillable);
        }
        //$result = AssayItem::create($fillable);
        
        return [$result];
    }

    public function show($id)
    {
      $assayItem = AssayItem::with("item")->find($id);
      if (empty($assayItem)) {
          Flash::error('Assay item not found');
          return redirect(route('assayForms.index'));
      }
      return $assayItem;

    }


    public function edit($id)
    {
      $assayItem = AssayItem::find($id);

      if (empty($assayItem)) {
          Flash::error('Assay item not found');
          return redirect(route('assayForms.index'));
      }

      return $assayItem;
    }


    public function update(Request $request, $id){
        $assayItem = AssayItem::find($id);

      if(empty($assayItem)){
          Flash::error('Assay item is not found');
          return redirect(route('assayForms.index'));
      }

      $input = $request->all();

        $_returned = $input['spend'] - $input['used'];

        //$returned = $_returned >= 0? $_returned : 0;
        if($_returned < 0){
            $returned_spend = $input['used'] - $input['spend'];
            $returned = 0;
        }else{
            $returned_spend =0;
            $returned = $_returned;
        }

        $fillable = [
            //'assay_form_id' => $input['assay_form_id'],
            'item_id' => $input['item_id'],
            'spend' => $input['spend'],
            'used' => $input['used'],
            'returned' => $returned,
            'returned_spend' => $returned_spend
        ];

      $assayItem->fill($fillable);
      $assayItem->save();

      return $assayItem;
    }

    
    public function destroy($id)
    {
        $assayItem = AssayItem::find($id);

      if (empty($assayItem)) {
          Flash::error('workOrdersPermitsExtension is not found');
          return redirect(route('assayForms.index'));
      }

        $assayItemDel = $assayItem->delete();
    }

  
}
