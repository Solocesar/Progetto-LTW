// Prendere elementi dal DOM

const CesarAPI = '7d8a0acbac9d46ce5f7a8ee14eb40411';
const url = 'https://api.themoviedb.org/3/search/movie?api_key=7d8a0acbac9d46ce5f7a8ee14eb40411';
const imageUrl = 'https://image.tmdb.org/t/p/w300/'

const buttonElement = document.querySelector("#search");
const searchText = document.querySelector("#searchText");
const ContenitoreFilm = document.querySelector("#ContenitoreFilm");


// sezione di un singolo film
function movieSection(movies) {
  return movies.map((movie) => {
    if (movie.poster_path) {
      return `<img src=${imageUrl + movie.poster_path} data-movie-id=${movie.id}/>`;
    }
  })
}

function createMovieContainer(movies) {
  const movieElement = document.createElement('div');
  movieElement.setAttribute('class', 'movie');

  const movietemplate = `
    <section class="section">
    ${movieSection(movies)}
    </section>
    <div class= "content content display">
      <p id="content-close">X</p>
      </div>
  `;
  movieElement.innerHTML = movietemplate;
  return movieElement;
}

function renderSearchMovies(data) {
  // array dei film 
  ContenitoreFilm.innerHTML='';  // pulisce il container dei film 
  const movies = data.results;
  const movieBlock = createMovieContainer(movies);
  ContenitoreFilm.appendChild(movieBlock);
  console.log("Data: ", data);
}

buttonElement.onclick = function (event) {
  event.preventDefault();
  const value = searchText.value;

  const newUrl = url + '&query=' + value;

  fetch(newUrl)
    .then((res) => res.json())
    .then(renderSearchMovies)
    .catch((error) => {
      console.log("Error: ", error);
    });
  searchText.value='';
  console.log("Value:", value);
};

// Event delegation
// click in qualunque  parte del documento e se il target e' un img

document.onclick = function(event){
  const target = event.target;
  if (target.tagName.toLowerCase() === 'img'){
    console.log('hello')
    const section = event.target.parentElement;
    const content = section.nextElementSibling;
    content.classList.add('content-display')
  }
}
