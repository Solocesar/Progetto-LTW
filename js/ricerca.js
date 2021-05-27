// Prendere elementi dal DOM

const buttonElement = document.querySelector("#search");
const searchText = document.querySelector("#searchText");
const ContenitoreFilm = document.querySelector("#ContenitoreFilm");
const popularMovies = document.querySelector("#popularMovies"); // popular and upcoming


function handleError(error) {
  console.log('Error: ', error.message);
  alert(error.message || 'Internal Server');
}


// sezione dei film
function movieSection(movies) {
  const section = document.createElement('section');
  section.classList = 'section';
  if (movies==null){
    alert("Titolo film non fornito")
    window.location.reload();
  }
  movies.map((movie) => {
    const img = document.createElement('img');
    img.src = imageUrl + movie.poster_path;
    img.setAttribute('data-movie-id', movie.id);
    img.setAttribute('onclick',`movieSelected(${movie.id},"${movie.title}")`)
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


  const section = movieSection(movies);

  movieElement.appendChild(header);
  movieElement.appendChild(section);
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
};


//Carica le sezioni di film popolari e in arrivo 
searchUpcomingMovies();
searchPopularMovies();



// js per la pagina di un unico film 
//aggiunta di php later on
function movieSelected(movieId,movieTitle) {
  // la session storage si cancella appena si chiude la tab / pagina.
  // var movieId= movie.id;
  sessionStorage.setItem('title', movieTitle);
  console.log(movieTitle);
  $.ajax({
    type: 'POST',
    url: 'jsphp.php',
    data: {'movie': movieId,'title':movieTitle}
  });


  sessionStorage.setItem('movieId', movieId);
  window.location.href = 'film.php';
  

  return false;
}

