<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $invoices = Invoice::withCount('orders')->paginate(5);
        $orders = Order::paginate(5);
        return view('backend.pages.order.index', compact('invoices','orders'));
    }

    public function edit($id)
    {
        $invoice = Invoice::where('id', $id)->firstOrFail();
        $order = Order::where('id', $id);
        return view('backend.pages.order.edit', compact('invoice','order'));
    }

    public function update(Request $request, $id)
    {
        $update = $request->status;
        Order::where('id', $id)->update(['status' => $update]);

        return back()->withSuccess('Updated Successfully');
    }

    public function destroy(Request $request)
    {
        $order = Order::where('id', $request->id)->firstOrFail();

        $order->delete();
        return response(['error' => false, 'message' => 'Deleted Successfully!']);
    }

    public function status(Request $request)
    {
        $update = $request->statu;
        $updateCheck = $update == "false" ? '0' : '1';

        Invoice::where('id', $request->id)->update(['status' => $updateCheck]);
        return response(['error' => false, 'status' => $update]);
    }
}
