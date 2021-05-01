// Prendere elementi dal DOM

const buttonElement = document.querySelector("#search");
const searchText = document.querySelector("#searchText");
const ContenitoreFilm = document.querySelector("#ContenitoreFilm");
const popularMovies = document.querySelector("#popularMovies");



const genres = [
  {
    "id": 28,
    "name": "Action"
  },
  {
    "id": 12,
    "name": "Adventure"
  },
  {
    "id": 16,
    "name": "Animation"
  },
  {
    "id": 35,
    "name": "Comedy"
  },
  {
    "id": 80,
    "name": "Crime"
  },
  {
    "id": 99,
    "name": "Documentary"
  },
  {
    "id": 18,
    "name": "Drama"
  },
  {
    "id": 10751,
    "name": "Family"
  },
  {
    "id": 14,
    "name": "Fantasy"
  },
  {
    "id": 36,
    "name": "History"
  },
  {
    "id": 27,
    "name": "Horror"
  },
  {
    "id": 10402,
    "name": "Music"
  },
  {
    "id": 9648,
    "name": "Mystery"
  },
  {
    "id": 10749,
    "name": "Romance"
  },
  {
    "id": 878,
    "name": "Science Fiction"
  },
  {
    "id": 10770,
    "name": "TV Movie"
  },
  {
    "id": 53,
    "name": "Thriller"
  },
  {
    "id": 10752,
    "name": "War"
  },
  {
    "id": 37,
    "name": "Western"
  }
]

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
  const movieBlock = createMovieContainer(movies);
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

// create iframe

// }
document.onclick = function (event) {
  event.preventDefault();
  const target = event.target;
  if (target.tagName.toLowerCase() === 'img') {
    const movieId = target.dataset.movieId;
    console.log('MovieID:', movieId);
    movieSelected(movieId);

  }
}


searchUpcomingMovies();
searchPopularMovies();



// js per la pagina di un unico film 

function movieSelected(movieId) {
  // la session storage si cancella appena si chiude la tab / pagina.
  // console.log(movieId);
  sessionStorage.setItem('movieId', movieId);
  window.location = 'film.html'
  return false;
}


