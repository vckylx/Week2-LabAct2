<?php
class Book{
    public $title;
    protected $author;
    private $price;

    function __construct($title, $author, $price){
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    function getDetails(){
        return "Title: $this->title, Author: $this->author, Price: \$$this->price";
    }

    function setPrice($price){
        $this->price = $price;
    }
    public function __call($method, $args){
        if ($method == 'updateStock') {
            echo "Stock updated for '{$this->title}' with arguments: " . implode(", ", $args);
        } else {
            echo "Method '$method' does not exist.\n";
        }
    }
}

class Library {
    private $books = [];
    public $name;

    function __construct($name){
        $this->name = $name;
    }
    function addBook(Book $book){
        $this->books[$book->title] = $book;
    }
    function removeBook($title) {
        if (isset($this->books[$title])){
            unset($this->books[$title]);
            echo "Book '$title' removed from the library.\n";
        } else {
            echo "Book '$title' not found in the library.\n";
        }
    }
    function listBooks(){
        if (empty($this->books)){
            echo "No books in the library.\n";
        } else {
            foreach ($this->books as $book){
                echo $book->getDetails() . "\n";
            }
        }
    }
    function __destruct(){
        echo "The library '{$this->name}' is now closed.\n";
    }
}

$library = new Library("City Library");

$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 12.99);
$book2 = new Book("1984", "George Orwell", 8.99);

$library->addBook($book1);
$library->addBook($book2);

try{
    echo $book1->updateStock(50) . "\n"; 
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

echo "Books in the library:\n";
$library->listBooks(); 
$library->removeBook("1984"); 
echo "Books in the library after removal:\n";
$library->listBooks(); 
unset($library); 

?>