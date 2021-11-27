<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *    $table->id();
     * $table->unsignedBigInteger('user_id');
     * $table->integer('status');
     * $table->integer('total');
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Order::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_order = new Order();
        $new_order->id = $request->id;
        $new_order->user_id = $request->user_id;
        $new_order->status = $request->status;
        $new_order->total = $request->total;

        $new_order->save();
        return response()->json($new_order);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        return [
            'id' => (string)$order->id,
            'data' => [

                'user_id' => $order->user_id,
                'status' => $order->status,
                'total' => $order->total,
                'created' => $order->created_at,
                'updated' => $order->updated_at,
            ],
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $old_order = Order::find($id);
        $old_order->delete();
        return response()->json('Order Deleted Successfully');
    }





}
