<?php

class BookModel
{
    protected $fillable = [
        'id',
        'name',
        'autor',
        'category',
        'price',
        'created_at',
        'updated_at',
    ];

    protected $timestamps = true;

    public function __construct()
    {
        $this->timestamps = true;
    }
}
