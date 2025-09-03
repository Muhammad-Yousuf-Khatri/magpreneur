class Like {
    constructor(){
        this.likeBtn = document.querySelector('.like-btn');
        this.event();
    }

    event(){
        this.likeBtn.addEventListener('click', this.ourClickDispatcher.bind(this));
    }

    // methods

    ourClickDispatcher(e){
        var currentLikeBox = e.target.closest(".like-btn");

        if(currentLikeBox.getAttribute('data-exists') == 'yes'){
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    }

    createLike(currentLikeBox){
        const postData = {
            'postID': currentLikeBox.getAttribute('data-postID')
        }
        fetch(magpreneur.root_url + '/wp-json/magpreneur/v1/manageLike', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': magpreneur.nonce
            },
            body: JSON.stringify(postData)
        })
        .then(async response =>{
            if(!response.ok){
                let errorMsg = `HTTP error! Status: ${response.status}`;
                try {
                    const findError = await response.json().catch(()=>({}));
                    if(findError?.data?.message){
                        errorMsg = findError.data.message;
                    }
                } catch (error) {
                    
                }
                throw new Error(errorMsg);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log("Like created:", data);
                currentLikeBox.setAttribute('data-exists', 'yes');
                currentLikeBox.querySelector('svg').setAttribute('data-prefix', 'fas');
                var numOfLikes = currentLikeBox.querySelector('.like-count');
                var likeCount = parseInt(numOfLikes.innerHTML ,10);
                likeCount++;
                numOfLikes.innerHTML = likeCount;
                currentLikeBox.setAttribute('data-likeID', data.data.likeID);
                console.log(likeCount);
            } else {
                console.error("Error:", data.data.message);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        })
    }

    deleteLike(currentLikeBox){
        const postData = {
            'likeID': currentLikeBox.getAttribute('data-likeID')
        }
        fetch(magpreneur.root_url + '/wp-json/magpreneur/v1/manageLike', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': magpreneur.nonce
            },
            body: JSON.stringify(postData)
        })
        .then(async response =>{
            if(!response.ok){
                let errorMsg = `HTTP error! Status: ${response.status}`;
                try {
                    const findError = await response.json().catch(()=>({}));
                    if(findError?.data?.message){
                        errorMsg = findError.data.message;
                    }
                } catch (error) {
                    
                }
                throw new Error(errorMsg);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log("Like Status:", data);
                currentLikeBox.setAttribute('data-exists', 'no');
                currentLikeBox.querySelector('svg').setAttribute('data-prefix', 'far');
                var numOfLikes = currentLikeBox.querySelector('.like-count');
                var likeCount = parseInt(numOfLikes.innerHTML ,10);
                likeCount--;
                numOfLikes.innerHTML = likeCount;
                currentLikeBox.setAttribute('data-likeID', '');
                console.log(likeCount);
            } else {
                console.error("Error:", data.data.message);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        })
    }
}

export default Like