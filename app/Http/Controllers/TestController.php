<?php

namespace App\Http\Controllers;


class TestController extends AppBaseController
{

    public function one()
    {
        return view('post.post_file');
    }

    public function many()
    {
        return view('post.post_files');
    }

    public function view($id)
    {
        $post = \App\Models\Post::with("attachments")->findOrFail($id);
        return view('post.view_file_list', ['post' => $post]);
    }

    public function test($request)
    {
        $post = \App\Models\Post::create([
            'title' => $request->get("title"),
            'body' => $request->get("body"),
        ]);
        return redirect()->route("post_view", ['id' => $post->id]);
    }

    public function fixWorkOrdersPermits()
    {
        $data = \App\Models\WorkOrdersPermit::whereIn('status', ['4', '5', '6', '7', '10'])->whereNull('restablish_convert_date')->orderBy('id', 'desc')->get();
        foreach ($data as $row) {
            if ($row->workOrders() && $row->workOrders()->first()) {
                $WorkOrderTransactionsHistory =  \App\Models\WorkOrderTransactionsHistory::where('new_department', 4)->where('work_order_id', $row->workOrders()->first()->id)->first();
                if ($WorkOrderTransactionsHistory) {
                    $row->restablish_convert_date = $WorkOrderTransactionsHistory->created_at;
                    $result = $row->save();
                }
            }
        }

        $data = \App\Models\WorkOrdersPermit::whereIn('status', ['4', '5', '6', '7'])->whereNull('restablish_convert_date')->orderBy('id', 'asc')->get();
        foreach ($data as $row) {
            if ($row->landLayers() && $row->landLayers()->first()) {

                if ($row->landLayers()->orderBy('id', 'asc')->first()) {
                    $row->restablish_convert_date = $row->landLayers()->orderBy('id', 'asc')->first()->created_at;
                    $result = $row->save();
                }
            }
        }

        $workOrdersPermits = \App\Models\WorkOrdersPermit::all();

        foreach ($workOrdersPermits as $permit) {

            $extension = \App\Models\WorkOrdersPermitsExtension::where('work_orders_permit_id', $permit->id)->get();
            $extensionAmount = $extension->sum('amount');
            $permit->total_amount = $permit->total_extend_amount + $permit->total_fines_amount + $permit->issued_amount + $permit->clearance_sdad_amount;
            $permit->total_extend_amount = $extensionAmount;
            $permit->save();
        }


        dd("Done");
    }
}
