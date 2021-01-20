<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
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
        $authors = Author::all();
        return $this->susccesResponse($authors);
    }
    /**
     * Create an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];
        $this->validate($request, $rules);
        $author = Author::create($request->all());
        return $this->susccesResponse($author, Response::HTTP_CREATED);

    }

    /**
     * Create an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);
        return $this->susccesResponse($author);

    }
    /**
     * Udate an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];
        $this->validate($request, $rules);
        $author = Author::findOrFail($author);
        $author->fill($request->all());
        if($author->is_clean()){
            return $this->errorResponse('at lea one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $author->save();
        return $this->susccesResponse($author, Response::HTTP_CREATED);


    }
    /**
     * Create an instance of Author
     *
     * @return Iluminate\Http\Response
     */
    public function destroy($author)
    {
       $author = Author::findOrFail($author);
       $author->delete();
       return $this->susccesResponse($author, Response::HTTP_OK);


    }
}
