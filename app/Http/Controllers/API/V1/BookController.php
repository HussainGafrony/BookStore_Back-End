<?php

namespace App\Http\Controllers\API\V1;

use App\Book;
use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
//    return  Book::with('category_id')->find($id);
        return response()->json(Book::all());

        //   return  [
        //         'id'=>(string)$books->id,
        //         'type'=>'Book',
        //     'attributes'=>[
        //          'name'=>$books->name,
        //          'image'=>$books->image,
        //          'category_id'=>$books->category_id,
        //          'price'=>$books->price,
        //          'stock'=>$books->stock,
        //          'description'=>$books->description,
        //          'review'=>$books->review,
        //          'created'=>$books->created_at,
        //          'updated'=>$books->updated_at,
        //     ]
        //     ];

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
        $new_books = new Book();
        $new_books->id = $request->id;
        $new_books->name = $request->name;
        $new_books->image = $request->image;
        $new_books->category_id = $request->category_id;
        $new_books->price = $request->price;
        $new_books->stock = $request->stock;
        $new_books->description = $request->description;
        $new_books->review = $request->review;
        $new_books->save();
        UserController::notifyUser($new_books);
        return response()->json($new_books);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show($id)
    {
        $books = Book::find($id);
//        $book = Book::with('category_id')->findOrFail($id);


        $data = [
            'id' => (string)$books->id,
            'type' => 'book',
            'attributes' => [
                'name' => $books->name,
                'image' => $books->image,
                'category_id' => $books->category_id,
                'price' => $books->price,
                'stock' => $books->stock,
                'description' => $books->description,
                'review' => $books->review,
                'created' => $books->created_at,
                'updated' => $books->updated_at,
            ]
        ];
        return $data;
//         return response()->json(Book::find($id));
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
        //
    }

    public function showCategoryOfBook($book_id)
    {
        $query1 = Book::where('id', $book_id)->with('category')->get();
return $query1;
//       $query1  = DB::select('select * from books where id = ?', [$book_id]);
//
//        $query1 = Book::where('id','LIKE', '%' . $book_id . '%')->get();
//        $result_of_query1 = array_map(
//            function ($value) {
//                return (array)$value;
//            },
//            $query1
//        );
//        return $query1;
//        $category_id = $result_of_query1[0]['category_id'];
//        $query2 = DB::select('select * from categories where id = ?', [$category_id]);
////
//        $result_of_query2 = array_map(
//            function ($value) {
//                return (array)$value;
//            },
//            $query2);

//        $category = $result_of_query2[0];
//        $category_title = $category['title'];
//        return response()->json($category);
    }


    public function searchBook($something)
    {
        $books =
            Book::where('name', 'LIKE', '%' . $something . '%')->get();
        if (count($books) > 0)
            return $books;

        else return 'No Details found. Try to search again !';

    }

}
