<?php

use MorsumMVC\Models\Book;

class BooksEndpointsTest extends MorsumMVCTestCase
{
    public function testIfCreateFailsIfMissingData()
    {
        $bookData = ['title' => 'Test Title', 'author' => ''];
        $response = $this->guzzle->request('POST', '/books', ['form_params' => $bookData]);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeader('Content-Type')[0]);
    }

    public function testCreateEndpoint()
    {
        $bookData = ['title' => 'Test Title', 'author' => 'Test Author'];
        $response = $this->guzzle->request('POST', '/books', ['form_params' => $bookData]);
        $data = json_decode((string) $response->getBody())->data;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeader('Content-Type')[0]);
        $this->assertEquals($bookData['title'], $data->title);
        $this->assertEquals($bookData['author'], $data->author);
        $this->assertTrue(is_numeric($data->id) && !empty($data->id));

        $this->assertEquals(Book::getById($data->id)->title, $bookData['title']);
        $this->assertEquals(Book::getById($data->id)->author, $bookData['author']);
    }

    public function testDeleteEndpoint()
    {
        $book = Book::create(['title' => 'Test01 Title', 'author' => 'Test01 Author']);
        $response = $this->guzzle->request('DELETE', "/books/{$book->id}");
        $responseBody = json_decode((string) $response->getBody());

        $this->assertNull(Book::getById($book->id));
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeader('Content-Type')[0]);
        $this->assertTrue($responseBody->success);
    }
}
