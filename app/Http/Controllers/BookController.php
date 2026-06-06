<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'authors'])->latest()->paginate(12);

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('last_name')->get();

        return view('books.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|size:13|unique:books,isbn',
            'publisher' => 'nullable|string|max:200',
            'publish_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'pages' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:30',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|url|max:500',
            'total_copies' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'authors' => 'required|array|min:1',
            'authors.*' => 'integer|exists:authors,id',
        ]);

        $validated['available_copies'] = $validated['total_copies'];

        $book = Book::create($validated);

        $book->authors()->sync($request->input('authors', []));

        session()->flash('success', 'Libro registrado exitosamente.');

        return redirect()->route('books.show', $book);
    }

    public function show(Book $book)
    {
        $book -> load(['authors', 'category', 'activeLoans.member.user']);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        $authors = Author::orderBy('last_name')->get();

        return view('books.edit', compact('book', 'categories', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:200',
            'publish_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'pages' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:30',
            'description' => 'nullable|string',
            'cover_url' => 'nullable|url|max:500',
            'total_copies' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'authors' => 'required|array|min:1',
            'authors.*' => 'integer|exists:authors,id',
        ]);

        $loanedCopies = $book->total_copies - $book->available_copies;
        $newTotal = $validated['total_copies'];

        $validated['available_copies'] = max(0, $newTotal - $loanedCopies);

        $book->update($validated);

        $book->authors()->sync($request->input('authors', []));

        session()->flash('success', 'Libro actualizado correctamente.');

        return redirect()->route('books.show', $book);
    }

    public function destroy(Book $book)
    {
        if ($book->activeLoans()->count() > 0) {
            return back()->with(
                'error',
                'No se puede eliminar un libro con préstamos activos.'
            );
        }

        $book->delete();

        session()->flash('success', 'Libro eliminado correctamente.');

        return redirect()->route('books.index');
    }
}
