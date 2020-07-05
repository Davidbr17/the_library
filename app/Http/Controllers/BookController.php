<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Category;
use App\User;

class BookController extends Controller
{
    public function home(){
       $data['books'] = Book::orderBy('id','desc')->with('category','borrowed_user')->get();
       $data['categories'] = Category::select('id as value','name as text')->get();
       $data['users'] = User::select('id as value','name as text')->get();

       return view('home',$data);
    }

    public function index(){
        return [
            'success' => true,
            'data' => $books = Book::orderBy('id','desc')->with('category','borrowed_user')->get()
        ];
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' =>'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        Book::create(array_merge($request->all(), ['published_date' => date("Y-m-d")]));

        return [
            'success' => true,
        ];
    } 

    public function lendBook(Request $request){
        $this->validate($request, [
            'id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $book = Book::find($request->id);
        $book->available = 0;
        $book->user_id = $request->user_id;
        $book->save();

        return ['success' => true];
    }

    public function unLendBook(Request $request){
        $this->validate($request, [
            'id' => 'required|exists:books,id',
        ]);

        $book = Book::find($request->id);
        $book->user_id = null;
        $book->available = 1;
        $book->save();

        return ['success' => true];
    }

    public function update($id,Request $request){
        $this->validate($request, [
            'name' =>'required',
            'author' => 'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        $book = Book::find($id);
        $book->name = $request->name;
        $book->author = $request->author;
        $book->category_id = $request->category_id;
        $book->save();

        return ['success' => true];

    }


    public function destroy($id){

        $book = Book::find($id);
        $book->status_ = 0;
        $book->save();

        return ['success' => true];
    }
}
