const API_KEY = 'api_key=7d8a0acbac9d46ce5f7a8ee14eb40411';
const BASE_URL = 'https://api.themoviedb.org/3';
/*const API_URL = BASE_URL + '/discover/movie?sort_by=popularity.desc&'+API_KEY;*/
const API_URL= BASE_URL+ '/movie/343611?' + API_KEY;
const IMG_URL = 'https://image.tmdb.org/t/p/w500';
const main= document.getElementById("main");
getMovies(API_URL);

function getMovies(url){

    fetch(url, {
        method: "GET",
        headers: {"Content-type": "application/json;charset=UTF-8"}
        })
        .then(response => response.json()) 
        .then(json=> showMovies(json));
    
}

function showMovies(data){
    console.log(data);
    console.log(data.title);
    main.innerHTML='';
    const {title, poster_path, overview} =data;
    const movie1= document.createElement("div");
    movie1.classList.add("movie");
    movie1.innerHTML= `
        <section class="box">
            <img src="${IMG_URL+poster_path}" alt="" />
            <div class="info-film">
                <h3 class="h1-f">${title}</h3>
                <p1>${overview}</p1>
            </div>
        </section>
        <hr class="linea-sep" color="black"></hr>

    `
    main.appendChild(movie1);
        
 
    

}
