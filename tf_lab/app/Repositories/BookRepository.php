<?php

namespace App\Repositories;

use App\Models\book\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository
{
    public function all(): Collection
    {
        return Book::all();
    }

    public function findById($id)
    {
        return Book::findOrFail($id);
    }

    public function create($data)
    {
        return Book::create($data);
    }

    public function update($id, $data)
    {
        $book = $this->findById($id);
        $book->update($data);
        return $book;
    }

    public function delete($id)
    {
        $this->findById($id)->delete();
    }
}
