class Search {

    // 1. describe and create/initiate our object

    constructor () {
        this.searchField = document.getElementById('search-term');
        this.searchResultDiv = document.querySelector('.search-suggestion-field');
        this.searchButton = document.querySelector('.my-search-btn');
        this.mySearchBox = document.querySelector('.my-search-box');
        this.previousValue;
        this.events();
        this.typingTimer;
    }

    // 2. events
    events () {
        this.searchField.addEventListener('keyup', this.typingLogic.bind(this));
        this.searchField.addEventListener('input', () => {
            this.searchResultDiv.classList.add('d-none');});
        this.searchButton.addEventListener('click', this.closeSearch.bind(this));
        
        if(this.mySearchBox.getAttribute('aria-hidden') === 'false'){
            console.log('aria is false');
            document.addEventListener('keyup', (e)=> {
            if(e.key==='Escape'){
                console.log("key");
                this.searchButton.click();
            };});
        }
    }

    // 3. methods(function, action...)
    closeSearch(){
        this.searchField.value = "";
        this.searchResultDiv.classList.add('d-none');
    }

    typingLogic(){
        if(this.searchField.value != this.previousValue){
            clearTimeout(this.typingTimer);

            if(this.searchField.value){
                this.typingTimer = setTimeout(this.getResult.bind(this), 1000);
            } else {
                this.searchField.innerHTML = "";
                this.searchResultDiv.classList.add('d-none');
            }  
        }
        this.previousValue = this.searchField.value;
    }

    getResult(){
        fetch(magpreneur.root_url + '/wp-json/magpreneur/v1/search?term=' + this.searchField.value)
            .then(response =>{
                if(!response.ok){
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            
            .then(posts => {
                this.searchResultDiv.classList.remove('d-none');
                this.searchResultDiv.innerHTML = `
                ${posts.topics.length ? '<ul class="mb-auto search-list__group py-3 px-3">' : '<p class="mb-0 p-2">Match not found</p>'}
                    ${posts.topics.map(item =>`<li class="mb-1 search-list__item"><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                ${posts.topics.length ? '</ul>' : ''}

                ${posts.webinars.length ? '<small class="webinars-search-result mb-auto py-2 px-3">Webinars</small> <ul class="mb-auto search-list__group webinars-search-list py-3 px-3">' : ''}
                    ${posts.webinars.map(item =>`<li class="mb-1 search-list__item"><a href="${item.permalink}">${item.title}</a>
                        <div class="webinar-status__container">
                            <span class="webinar-status__${item.status == 'Upcoming' ? 'upcoming' : 'past'}">${item.status}</span>
                        </div>
                        </li>`).join('')}
                ${posts.webinars.length ? '</ul>' : ''}
                `})

            .catch(error => {
            console.error("Fetch error:", error);
            this.searchResultDiv.classList.remove('d-none');
            this.searchResultDiv.innerHTML = `<p class="mb-0 p-2 text-danger">Something went wrong. Please try again later.</p>`;
            });
    }
}

export default Search