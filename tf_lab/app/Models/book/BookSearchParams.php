<?php

namespace App\Models\book;

class BookSearchParams
{
    public mixed $maxMembers;
    public mixed $minMembers;
    public mixed $toDate;
    public mixed $fromDate;
    public mixed $ageRating;
    public mixed $author;
    public mixed $language;
    public mixed $genre;
    public mixed $sort;

    public function __construct(array $params)
    {
        $this->sort = $params['sort'] ?? 1;
        $this->genre = $params['genre'] ?? null;
        $this->language = $params['language'] ?? null;
        $this->author = $params['author'] ?? null;
        $this->ageRating = $params['ageRating'] ?? null;
        $this->fromDate = $params['fromDate'] ?? null;
        $this->toDate = $params['toDate'] ?? null;
        $this->minMembers = $params['minMembers'] ?? null;
        $this->maxMembers = $params['maxMembers'] ?? null;
    }
}
