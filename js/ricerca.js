// Prendere elementi dal DOM

const buttonElement = document.querySelector("#search");
const searchText = document.querySelector("#searchText");
const ContenitoreFilm = document.querySelector("#ContenitoreFilm");
const popularMovies = document.querySelector("#popularMovies");


function handleError(error) {
  console.log('Error: ', error.message);
  alert(error.message || 'Internal Server');
}


// sezione di un singolo film
function movieSection(movies) {
  const section = document.createElement('section');
  section.classList = 'section';
  movies.map((movie) => {
    const img = document.createElement('img');
    img.src = imageUrl + movie.poster_path;
    img.setAttribute('data-movie-id', movie.id);
    img.setAttribute('onclick',`movieSelected(${movie.id})`)
    section.appendChild(img);
  })
  return section;
}

function createMovieContainer(movies, title = '') {

  const movieElement = document.createElement('div');
  movieElement.setAttribute('class', 'movie');

  //crea la sezione per il titolo 
  const header = document.createElement('h2');
  header.innerHTML = title;

  const content = document.createElement('div');
  content.classList = 'content';

  const section = movieSection(movies);

  movieElement.appendChild(header);
  movieElement.appendChild(section);
  movieElement.appendChild(content);
  return movieElement;
}

function renderSearchMovies(data) {
  // array dei film 
  ContenitoreFilm.innerHTML = '';  // pulisce il container dei film 
  const movies = data.results;
  const movieBlock = createMovieContainer(movies,'Risultati');
  ContenitoreFilm.appendChild(movieBlock);
  // console.log("Data: ", data);
}

// per i film popolari ,in arrivo , ecc
function renderMovies(data) {
  // array dei film 
  const movies = data.results;
  const movieBlock = createMovieContainer(movies, this.title);
  popularMovies.appendChild(movieBlock);
}

buttonElement.onclick = function (event) {
  event.preventDefault();
  const value = searchText.value;
  searchMovie(value);

  searchText.value = '';
  // console.log("Value:", value);
};


//Carica le sezioni di film popolari e in arrivo 
searchUpcomingMovies();
searchPopularMovies();



// js per la pagina di un unico film 

function movieSelected(movieId) {
  // la session storage si cancella appena si chiude la tab / pagina.
  console.log(movieId);
  var data = {
    fn: "filename",
    str: "this_is_a_dummy_test_string"
  };
  $.get("film.php", data);

  sessionStorage.setItem('movieId', movieId);
  window.location = 'film.php';
  return false;
}


