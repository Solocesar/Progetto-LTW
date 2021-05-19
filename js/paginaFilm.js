var API_KEY1 = 'api_key=7d8a0acbac9d46ce5f7a8ee14eb40411';
var BASE_URL1 = 'https://api.themoviedb.org/3';
/*const API_URL = BASE_URL + '/discover/movie?sort_by=popularity.desc&'+API_KEY;*/
var IMG_URL1 = 'https://image.tmdb.org/t/p/w500';
console.log("nome:"+sessionStorage.getItem("movieId1"));
var API_URL1= BASE_URL1+ '/movie/'+ sessionStorage.getItem("movieId1")+'?' + API_KEY1;
getMovies(API_URL1);

function getMovies(url){

    fetch(url, {
        method: "GET",
        headers: {"Content-type": "application/json;charset=UTF-8"}
        })
        .then(response => response.json()) 
        .then(json=> showMovies(json));
    
}

function showMovies(data){
    
    const {title, poster_path} =data;
    $.ajax({
        type: 'POST',
        url: 'http://localhost/Progetto-LTW/filmInfo.php',
        data: {'title':title}
    });

}
