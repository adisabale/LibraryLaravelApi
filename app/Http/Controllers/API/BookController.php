<?php
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\{Book,BookDetail};
use Validator;
use App\Http\Resources\Book as BookResource;
   
class BookController extends BaseController
{

    public function index()
    {
        $book = Book::join('book_details','book_details.book_id','=','books.id')
                      ->get(['books.*','book_details.description','book_details.pages','book_details.publisher']);
    
        return $this->sendResponse(BookResource::collection($book), 'Book retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
        'category_id'  => 'required',
        'uuid'         => 'required',
        'name'         => 'required',
        'releaseDate'  => 'required',
        'authorName'   => 'required',
        'retailsPrice' => 'required',
        'imageName'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'description'  => 'required',
        'pages'        => 'required',
        'publisher'    => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if($request->file('imageName')){
            $file= $request->file('imageName');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/images/'), $filename);
        }

        $book = Book::create([
            'category_id'  => $input['category_id'],
            'uuid'         => $input['uuid'],
            'name'         => $input['name'],
            'releaseDate'  => $input['releaseDate'],
            'authorName'   => $input['authorName'],
            'retailsPrice' => $input['retailsPrice'],
            'imageName'    => $filename,
        ]);

        $book['book_details'] = BookDetail::create([
             'book_id'      => $book->id,
             'description'  => $input['description'],
             'pages'        => $input['pages'],
             'publisher'    => $input['publisher'],
        ]);

        return $this->sendResponse(new BookResource($book), 'Book created successfully.');
    } 
   
    public function show($id)
    {
        $book = Book::join('book_details','book_details.book_id','=','books.id')
                      ->where('books.id',$id)
                      ->get(['books.*','book_details.description','book_details.pages','book_details.publisher']);
  
        if ($book->isEmpty()) {
            return $this->sendError('Book not found.');
        }
        return $this->sendResponse(new BookResource($book), 'Book retrieved successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }else{
            $input = $request->all();
            if($request->file('imageName')){
                if(file_exists(public_path("/images/".$book->imageName))){
                    unlink(public_path("/images/".$book->imageName));
                }
                $file= $request->file('imageName');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file-> move(public_path('/images/'), $filename);

                $input['imageName'] = $filename;
            }
            $book->update($input);
            $book['book_details'] =  BookDetail::where('book_id', $book->id)->first();
            $book['book_details']->update($input);
        }
        return $this->sendResponse(new BookResource($book), 'Book updated successfully.');
    }
   
    public function destroy($id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }else{
            $book['book_details'] =  BookDetail::where('book_id', $book->id)->first();
            $book['book_details']->delete();
            if(file_exists(public_path("/images/".$book->imageName))){
                    unlink(public_path("/images/".$book->imageName));
            }
            $book->delete();
        }
        return $this->sendResponse([], 'Book deleted successfully.');
    }
}