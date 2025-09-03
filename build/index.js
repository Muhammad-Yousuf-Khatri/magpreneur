/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/modules/Like.js":
/*!*****************************!*\
  !*** ./src/modules/Like.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class Like {
  constructor() {
    this.likeBtn = document.querySelector('.like-btn');
    this.event();
  }
  event() {
    this.likeBtn.addEventListener('click', this.ourClickDispatcher.bind(this));
  }

  // methods

  ourClickDispatcher(e) {
    var currentLikeBox = e.target.closest(".like-btn");
    if (currentLikeBox.getAttribute('data-exists') == 'yes') {
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }
  createLike(currentLikeBox) {
    const postData = {
      'postID': currentLikeBox.getAttribute('data-postID')
    };
    fetch(magpreneur.root_url + '/wp-json/magpreneur/v1/manageLike', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': magpreneur.nonce
      },
      body: JSON.stringify(postData)
    }).then(async response => {
      if (!response.ok) {
        let errorMsg = `HTTP error! Status: ${response.status}`;
        try {
          const findError = await response.json().catch(() => ({}));
          if (findError?.data?.message) {
            errorMsg = findError.data.message;
          }
        } catch (error) {}
        throw new Error(errorMsg);
      }
      return response.json();
    }).then(data => {
      if (data.success) {
        console.log("Like created:", data);
        currentLikeBox.setAttribute('data-exists', 'yes');
        currentLikeBox.querySelector('svg').setAttribute('data-prefix', 'fas');
        var numOfLikes = currentLikeBox.querySelector('.like-count');
        var likeCount = parseInt(numOfLikes.innerHTML, 10);
        likeCount++;
        numOfLikes.innerHTML = likeCount;
        currentLikeBox.setAttribute('data-likeID', data.data.likeID);
        console.log(likeCount);
      } else {
        console.error("Error:", data.data.message);
      }
    }).catch(error => {
      console.error("Fetch error:", error);
    });
  }
  deleteLike(currentLikeBox) {
    const postData = {
      'likeID': currentLikeBox.getAttribute('data-likeID')
    };
    fetch(magpreneur.root_url + '/wp-json/magpreneur/v1/manageLike', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': magpreneur.nonce
      },
      body: JSON.stringify(postData)
    }).then(async response => {
      if (!response.ok) {
        let errorMsg = `HTTP error! Status: ${response.status}`;
        try {
          const findError = await response.json().catch(() => ({}));
          if (findError?.data?.message) {
            errorMsg = findError.data.message;
          }
        } catch (error) {}
        throw new Error(errorMsg);
      }
      return response.json();
    }).then(data => {
      if (data.success) {
        console.log("Like Status:", data);
        currentLikeBox.setAttribute('data-exists', 'no');
        currentLikeBox.querySelector('svg').setAttribute('data-prefix', 'far');
        var numOfLikes = currentLikeBox.querySelector('.like-count');
        var likeCount = parseInt(numOfLikes.innerHTML, 10);
        likeCount--;
        numOfLikes.innerHTML = likeCount;
        currentLikeBox.setAttribute('data-likeID', '');
        console.log(likeCount);
      } else {
        console.error("Error:", data.data.message);
      }
    }).catch(error => {
      console.error("Fetch error:", error);
    });
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Like);

/***/ }),

/***/ "./src/modules/Search.js":
/*!*******************************!*\
  !*** ./src/modules/Search.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class Search {
  // 1. describe and create/initiate our object

  constructor() {
    this.searchField = document.getElementById('search-term');
    this.searchResultDiv = document.querySelector('.search-suggestion-field');
    this.searchButton = document.querySelector('.my-search-btn');
    this.mySearchBox = document.querySelector('.my-search-box');
    this.previousValue;
    this.events();
    this.typingTimer;
  }

  // 2. events
  events() {
    this.searchField.addEventListener('keyup', this.typingLogic.bind(this));
    this.searchField.addEventListener('input', () => {
      this.searchResultDiv.classList.add('d-none');
    });
    this.searchButton.addEventListener('click', this.closeSearch.bind(this));
    if (this.mySearchBox.getAttribute('aria-hidden') === 'false') {
      console.log('aria is false');
      document.addEventListener('keyup', e => {
        if (e.key === 'Escape') {
          console.log("key");
          this.searchButton.click();
        }
        ;
      });
    }
  }

  // 3. methods(function, action...)
  closeSearch() {
    this.searchField.value = "";
    this.searchResultDiv.classList.add('d-none');
  }
  typingLogic() {
    if (this.searchField.value != this.previousValue) {
      clearTimeout(this.typingTimer);
      if (this.searchField.value) {
        this.typingTimer = setTimeout(this.getResult.bind(this), 1000);
      } else {
        this.searchField.innerHTML = "";
        this.searchResultDiv.classList.add('d-none');
      }
    }
    this.previousValue = this.searchField.value;
  }
  getResult() {
    fetch(magpreneur.root_url + '/wp-json/magpreneur/v1/search?term=' + this.searchField.value).then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    }).then(posts => {
      this.searchResultDiv.classList.remove('d-none');
      this.searchResultDiv.innerHTML = `
                ${posts.topics.length ? '<ul class="mb-auto search-list__group py-3 px-3">' : '<p class="mb-0 p-2">Match not found</p>'}
                    ${posts.topics.map(item => `<li class="mb-1 search-list__item"><a href="${item.permalink}">${item.title}</a></li>`).join('')}
                ${posts.topics.length ? '</ul>' : ''}

                ${posts.webinars.length ? '<small class="webinars-search-result mb-auto py-2 px-3">Webinars</small> <ul class="mb-auto search-list__group webinars-search-list py-3 px-3">' : ''}
                    ${posts.webinars.map(item => `<li class="mb-1 search-list__item"><a href="${item.permalink}">${item.title}</a>
                        <div class="webinar-status__container">
                            <span class="webinar-status__${item.status == 'Upcoming' ? 'upcoming' : 'past'}">${item.status}</span>
                        </div>
                        </li>`).join('')}
                ${posts.webinars.length ? '</ul>' : ''}
                `;
    }).catch(error => {
      console.error("Fetch error:", error);
      this.searchResultDiv.classList.remove('d-none');
      this.searchResultDiv.innerHTML = `<p class="mb-0 p-2 text-danger">Something went wrong. Please try again later.</p>`;
    });
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Search);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_Search__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/Search */ "./src/modules/Search.js");
/* harmony import */ var _modules_Like__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/Like */ "./src/modules/Like.js");


const liveSearch = new _modules_Search__WEBPACK_IMPORTED_MODULE_0__["default"]();
const like = new _modules_Like__WEBPACK_IMPORTED_MODULE_1__["default"]();
})();

/******/ })()
;
//# sourceMappingURL=index.js.map