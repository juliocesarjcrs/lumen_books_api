<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponserTrait;

class BookController extends Controller
{
    use ApiResponserTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * index
     *
     * @return Iluminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return $this->susccesResponse($books);
    }
    /**
     * Create an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required',
            'author_id' => 'required',
        ];
        $this->validate($request, $rules);
        $author = Book::create($request->all());
        return $this->susccesResponse($author, Response::HTTP_CREATED);

    }

    /**
     * Create an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function show($book)
    {
        $book = Book::findOrFail($book);
        return $this->susccesResponse($book);

    }
    /**
     * Udate an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function update(Request $request, $book)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required',
            'author_id' => 'required',
        ];
        $this->validate($request, $rules);
        $book = Book::findOrFail($book);
        $book->fill($request->all());
        if($book->is_clean()){
            return $this->errorResponse('at lea one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $book->save();
        return $this->susccesResponse($book, Response::HTTP_CREATED);


    }
    /**
     * Create an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function destroy($book)
    {
       $book = Book::findOrFail($book);
       $book->delete();
       return $this->susccesResponse($book, Response::HTTP_OK);


    }
}
