<?php 

class Book {
    private $id;
    private $title;
    private $author;
    private $category;
    private $release_date;
    private $available;

    public function __construct($id, $title, $author, $category, $release_date, $available) {
        $this->title = $title;
        $this->author = $author;
        $this->category = $category;
        $this->release_date = $release_date;
        $this->id = $id;
        $this->available = $available;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getReleaseDate() {
        return $this->release_date;
    }

    public function getAvailability() {
        return $this->available;
    }

    public function getInfo() {
        return "ID: {$this->id}, Title: {$this->title}, Author: {$this->author}, Category: {$this->category}, Release Date: {$this->release_date}, Available: " . ($this->available ? 'Yes' : 'No');
    }
}

class Library {
    private $books = [];

    // To add a new book
    public function addBook( Book $book ) {
        $this->books[ $book->getId() ] = $book;
    }

    // To edit a book
    public function editBook($id, $title, $author, $category, $release_date, $available) {
        if (isset($this->books[$id])) {
            $this->books[$id] = new Book($id, $title, $author, $category, $release_date, $available);
        }
    }

    // To delete a book
    public function deleteBook( $id ) {
        if ( isset( $this->books[$id] ) ) {
            unset( $this->books[$id] );
        }
    }

    // To search a book by title, author or category
    public function searchBook( $word ) {
        $results = [];
        foreach( $this->books as $book ) {
            if ( stripos( $book->getTitle(), $word ) !== false ||
                 stripos( $book->getAuthor(), $word )!== false ||
                 stripos( $book->getCategory(), $word )!== false ) {
                 $results[] = $book;
            } 
        }
        return $results;
    }

    // To borrow a book
    public function borrowBook( $id ) {
        if ( isset( $this->books[$id] ) && $this->books[$id]->getAvailability() ) {
            $this->books[$id]->availability = false;
            return true; // It was successfully retrieved
        } else {
            return false; // It was not successfully retrieved or not available
        }
    }
}

$library = new Library();

// Adding some books example
$library->addBook(new Book( 1, "The Lord of the Rings", "J.R.R. Tolkien", "Fantasy", "July 1954", "Yes") );
$library->addBook(new Book( 2, "Harry Potter and the Philosopher's Stone", "J.K. Rowling", "Fantasy", "September 1978", "Yes") );
$library->addBook(new Book( 3, "IT", "Stephen King", "Horror", "September 1986", "Yes") );
$library->addBook(new Book( 4, "To Kill a Mockingbird", "Harper Lee", "Classic", "July 1960", "Yes") );

// Search books
$results = $library->searchBook( "philosopher's" );
foreach( $results as $book ) {
    echo $book->getInfo(). "\n";
}

// Borrowing a book
if ( $library->borrowBook( 1 ) ) {
    echo "The book was successfully borrowed \n";
} else {
    echo "The book was not successfully borrowed, try again later \n";
}

// Editing a book
$library->editBook( 1, "Romeo and Juliet", "William Shakespeare", "Romantic", "1597", "Yes" );


echo "Updated book information:\n";
$updatedBook = $library->searchBook("Romeo and Juliet")[0];
echo $updatedBook->getInfo() . "\n";

// Deleting a book
$library->deleteBook( 2 );

// Remaining books in library
echo "Remaining books in library are:\n";
foreach( $library->searchBook("") as $book ) {
    echo $book->getInfo(). "\n";
}


?>
