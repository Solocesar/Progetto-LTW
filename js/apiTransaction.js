
const API_KEY = '7d8a0acbac9d46ce5f7a8ee14eb40411';
const url = 'https://api.themoviedb.org/3/search/movie?api_key=7d8a0acbac9d46ce5f7a8ee14eb40411';
const imageUrl = 'https://image.tmdb.org/t/p/w300/'

//genera url corretto
function generateUrl(path) {
    const url = `https://api.themoviedb.org/3${path}?api_key=7d8a0acbac9d46ce5f7a8ee14eb40411`;
    return url;
}

function requestMovies(url, onComplete, OnError) {
    fetch(url)
        .then((res) => res.json())
        .then(onComplete)
        .catch(OnError);
}

function searchMovie(value) {
    const path = '/search/movie'
    const url = generateUrl(path) + '&query=' + value;

    requestMovies(url, renderSearchMovies, handleError);
}


function searchUpcomingMovies() {
    const path = '/movie/upcoming'
    const url = generateUrl(path);
    const render = renderMovies.bind({ title: 'In Arrivo' })
    requestMovies(url, render, handleError);
}

function searchPopularMovies() {
    const path = '/movie/popular'
    const url = generateUrl(path);
    const render = renderMovies.bind({ title: 'Popolari' })
    requestMovies(url, render, handleError);
}
