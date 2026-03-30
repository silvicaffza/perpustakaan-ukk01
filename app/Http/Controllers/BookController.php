<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('categories')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required|numeric',
            'stock' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $coverPath = null;

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'stock' => $request->stock,
            'description' => $request->description,
            'cover' => $coverPath,
        ]);

        $book->categories()->attach($request->categories);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    { 
        $categories = Category::all();
        return view('books.edit', compact('book','categories'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required|numeric',
            'stock' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'title',
            'author',
            'publisher',
            'year',
            'stock',
            'description'
        ]);

        if ($request->hasFile('cover')) {

            // hapus cover lama kalau ada
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }

            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);

        $book->categories()->sync($request->categories);

        return redirect()->route('books.index')
            ->with('success', 'Buku berhasil diupdate');
    }
    
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index');
    }
}