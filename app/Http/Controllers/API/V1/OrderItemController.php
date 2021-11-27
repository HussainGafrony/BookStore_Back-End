<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(OrderItem::all());

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_orderitem= new OrderItem();
        $new_orderitem->id=$request->id;
        $new_orderitem->order_id=$request->order_id;
        $new_orderitem->book_id=$request->book_id;
        $new_orderitem->price=$request->price;
        $new_orderitem->quantity=$request->quantity;
        $new_orderitem->total=$request->total;
        $new_orderitem->save();
        return response()->json($new_orderitem);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderitem=OrderItem::find($id);

        return  [
            'id'=>(string)$orderitem->id,
             'data'=>[

            'order_id'=>$orderitem->order_id,
            'book_id'=>$orderitem->book_id,
            'price'=>$orderitem->price,
            'quantity'=>$orderitem->quantity,
            'total'=>$orderitem->total,
            'created'=>$orderitem->created_at,
            'updated'=>$orderitem->updated_at,
             ],
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $old_orderitem = OrderItem::find($id);
        $old_orderitem->delete();
        return response()->json('OrderItem Deleted Successfully');
    }
    public function getAllItems($id)
    {
        $items =OrderItem::where('order_id',$id)->with(['order','book'])->get();
        return $items;

    }
}
