# OMDb API SDK
A simple SDK for the Open movie database api.

[Click here](http://www.omdbapi.com) to read the omdb api documentation

## Examples

### Creating the client
```PHP
$client = new \KyleBlanker\Omdb\Client('<your_api_key>');
```
### Methods
A list of methods and their return type

- year: self
- search: self
- type: self
- fullPlot: self
- page: self
- get: \KyleBlanker\Omdb\Response
- getByImdbID: \KyleBlanker\Omdb\Response
- getPoster: array[content,mime]|null

### Examples
```PHP
$client = new \KyleBlanker\Omdb\Client('<your_api_key>');
$response = $client->year(1988)->search('The Land Before Time')->get();
var_dump($response->results());
```

```
array (size=1)
  0 => 
    object(stdClass)[55]
      public 'Title' => string 'The Land Before Time' (length=20)
      public 'Year' => string '1988' (length=4)
      public 'imdbID' => string 'tt0095489' (length=9)
      public 'Type' => string 'movie' (length=5)
      public 'Poster' => string 'https://m.media-amazon.com/images/M/MV5BNDVhZjVmZWYtYTE0OC00MGFjLWI1YWQtZmJhNmE5NzI4ZWE4XkEyXkFqcGdeQXVyMzczMzE2ODM@._V1_SX300.jpg' (length=130)
```

```PHP
$client = new \KyleBlanker\Omdb\Client('<your_api_key>');
$response = $client->getByImdbID('tt0095489');
var_dump($response->results());
```

```
array (size=1)
  0 => 
    object(stdClass)[55]
      public 'Title' => string 'The Land Before Time' (length=20)
      public 'Year' => string '1988' (length=4)
      public 'Rated' => string 'G' (length=1)
      public 'Released' => string '18 Nov 1988' (length=11)
      public 'Runtime' => string '69 min' (length=6)
      public 'Genre' => string 'Animation, Adventure, Drama' (length=27)
      public 'Director' => string 'Don Bluth' (length=9)
      public 'Writer' => string 'Stu Krieger (screenplay), Judy Freudberg (story), Tony Geiss (story)' (length=68)
      public 'Actors' => string 'Judith Barsi, Pat Hingle, Gabriel Damon, Helen Shaver' (length=53)
      public 'Plot' => string 'An orphaned brontosaurus teams up with other young dinosaurs in order to reunite with their families in a valley.' (length=113)
      public 'Language' => string 'English' (length=7)
      public 'Country' => string 'USA, Ireland' (length=12)
      public 'Awards' => string '2 nominations.' (length=14)
      public 'Poster' => string 'https://m.media-amazon.com/images/M/MV5BNDVhZjVmZWYtYTE0OC00MGFjLWI1YWQtZmJhNmE5NzI4ZWE4XkEyXkFqcGdeQXVyMzczMzE2ODM@._V1_SX300.jpg' (length=130)
      public 'Ratings' => 
        array (size=3)
          0 => 
            object(stdClass)[56]
              ...
          1 => 
            object(stdClass)[57]
              ...
          2 => 
            object(stdClass)[58]
              ...
      public 'Metascore' => string '66' (length=2)
      public 'imdbRating' => string '7.4' (length=3)
      public 'imdbVotes' => string '70,194' (length=6)
      public 'imdbID' => string 'tt0095489' (length=9)
      public 'Type' => string 'movie' (length=5)
      public 'DVD' => string '30 Apr 1997' (length=11)
      public 'BoxOffice' => string 'N/A' (length=3)
      public 'Production' => string 'MCA Universal Home Video' (length=24)
      public 'Website' => string 'N/A' (length=3)
      public 'Response' => string 'True' (length=4)
```