document.addEventListener('DOMContentLoaded', function () {

  function toggleSearchIcon(icon) {
    if (icon.classList.contains('fa-magnifying-glass')) {
      icon.classList.remove('fa-magnifying-glass');
      icon.classList.add('fa-circle-xmark');
      searchBox.setAttribute('aria-hidden', 'false');
    } else {
      icon.classList.remove('fa-circle-xmark');
      icon.classList.add('fa-magnifying-glass');
      searchBox.setAttribute('aria-hidden', 'true');
    }
  }
  
  window.toggleSearchIcon = toggleSearchIcon;
  
  document.addEventListener('show.bs.offcanvas', function () {
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = `${scrollbarWidth}px`;
  });
  
  document.addEventListener('hidden.bs.offcanvas', function () {
    document.body.style.overflow = 'visible';
    document.body.style.paddingRight = '0';
  });

  const header = document.querySelector(".navbar");
  const expendHeader = document.querySelector(".expend-animate-container")
  const mainHeader = document.querySelector(".main-header");
  var lastScrollTop = 0;
  var shrinkPoint = 95;
  var hidePoint = 280;
  const adminBar = document.getElementById("wpadminbar");
  if (adminBar){
  var adminBarGap = adminBar.offsetHeight;
  }
  // window.onscroll = function(){scrollHide(),scrollShrink()};
  window.addEventListener('scroll',()=>{
    if (searchVisibility){
      scrollHide();
    }
    scrollShrink();
    if(adminBar){
    var hiddenHeader = header.classList.contains('hide');
    var hiddenPixelPoint = 80;
      if(!hiddenHeader){
        header.style.top=adminBarGap+"px";
      } else {
        header.style.top="-" + ((adminBarGap+hiddenPixelPoint) +"px" );
      }
    }
  });

  function scrollHide() {
    var st = window.scrollY || document.documentElement.scrollTop;
    if (st > hidePoint) {
      header.classList.add('hide');
    } else {
      header.classList.remove('hide');
    }
    hidePoint = st <= 280 ? 280 : st;
  }

  function scrollShrink() {
    var st2 = window.scrollY || document.documentElement.scrollTop;
    if (st2 > shrinkPoint) {
      expendHeader.classList.add('expend-animate-hide');
      mainHeader.classList.add('glass-header');
    } else {
      expendHeader.classList.remove('expend-animate-hide');
      mainHeader.classList.remove('glass-header');
    }
  }

  const searchButton = document.querySelector('.my-search-btn');
  const searchBox = document.querySelector('.my-search-box');
  const logoColumn = document.querySelector('.logo-column')
  const headerBtnsColumn = document.querySelector('.header-btns-column');
  const headerNav = document.querySelector('.header-nav-column');
  var searchVisibility = searchBox.classList.contains('d-none');

  function isSearchOpenLg(){
    if(!searchVisibility){
      logoColumn.classList.remove('d-none');
      headerNav.classList.remove('d-lg-block');
      expendSearchColumn('9');
      headerBtnsColumn.classList.remove('col-10');
    } 
  }

  function isSearchOpenMd(){
    if(!searchVisibility){
      headerNav.classList.add('d-lg-block');
      logoColumn.classList.add('d-none');
      expendSearchColumn('10');
      headerBtnsColumn.classList.remove('col-9');
    } 
  }

  function updateHeaderColumn(){
    const checkViewportForHeader = window.matchMedia("(min-width: 992px)");
    checkViewportForHeader.onchange = (e) => {
    if(e.matches){
      isSearchOpenLg();
    } else {
      isSearchOpenMd();
    }
  }
  }

  function isCurrentlyDesktop() {
    return window.innerWidth >= 992;
  }

  function toggleSearchLg() {
    if (searchVisibility) {
      searchBox.classList.remove('d-none');
      headerNav.classList.remove('d-lg-block');
      expendSearchColumn('9');
    } else {
      searchBox.classList.add('d-none');
      headerNav.classList.add('d-lg-block');
      expendSearchColumn('9');
    }
  }

  function toggleSearchMd() {
    if (searchVisibility) {
      searchBox.classList.remove('d-none');
      logoColumn.classList.add('d-none');
      expendSearchColumn('10');
    } else {
      searchBox.classList.add('d-none');
      logoColumn.classList.remove('d-none');
      expendSearchColumn('10');
    }
  }

  function expendSearchColumn(num) {
    var expendedBtnsCol = headerBtnsColumn.classList.contains('col-' + num)
    if (!expendedBtnsCol) {
      headerBtnsColumn.classList.add('col-' + num);
    } else {
      headerBtnsColumn.classList.remove('col-' + num);
    }
  }

  function toggleSearch() {
    if (isCurrentlyDesktop()) {
      toggleSearchLg();
    } else {
      toggleSearchMd();
    }
    searchVisibility = searchBox.classList.contains('d-none');
  }

  searchButton.addEventListener('click', toggleSearch);
  updateHeaderColumn();
});