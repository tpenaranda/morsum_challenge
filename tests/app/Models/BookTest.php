<?php

use MorsumMVC\Models\Book;

/**
 * @covers MorsumMVC\Models\Book
 */
class BookTest extends MorsumMVCTestCase
{
    public function testsIfValidationFailsWithMissingData()
    {
        $this->assertFalse(Book::validate(['title' => 'Some Title', 'author' => '']));
    }

    public function testsIfValidatesGoodData()
    {
        $this->assertTrue(Book::validate(['title' => 'Some Title', 'author' => 'An author']));
    }

    public function testsIfBooksCanBeCreated()
    {
        $book = Book::create(['title' => 'Test Title', 'author' => 'Test Author']);
        $this->assertInstanceOf('MorsumMVC\Models\Book', $book);
    }

    public function testsIfBooksCanBeFetched()
    {
        $book = Book::create(['title' => 'Test Title', 'author' => 'Test Author']);
        $fetchedBook = Book::getById($book->id);

        $this->assertEquals($book->id, $fetchedBook->id);
        $this->assertEquals($book->author, $fetchedBook->author);
        $this->assertEquals($book->title, $fetchedBook->title);
    }
}
