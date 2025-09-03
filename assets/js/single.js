document.addEventListener('DOMContentLoaded', function(){
  const tocBTN = document.querySelector('.btn-offcanvas');
  const tocHeading = document.querySelector('.toc-heading');
  const tocCloseBTN = document.querySelector('.btn-offcanvas-close');
  const offCanvas = document.querySelector('.toc-offcanvas');
  const bookmarkBTN = document.querySelector('.bookmark-button');

  bookmarkBTN.addEventListener('click', ()=>{
    alert("To bookmark the current page, press Ctrl+D on Windows or Cmd+D on Mac.");
  })

  tocBTN.addEventListener('click', () => {
    tocBTN.style.transform = `translateX(-${50}px)`;
  });

  tocCloseBTN.addEventListener('click', () => {
    tocBTN.style.transform = `translateX(${0}px)`;
  });

  offCanvas.addEventListener('hide.bs.offcanvas', event => {
    tocBTN.style.transform = `translateX(${0}px)`;
  });

  window.addEventListener('scroll', () => {
    const scrollVarticle = window.scrollY;
    const maxScroll = 500;
    const maxTocScroll = 100;

    if (scrollVarticle > 230) {
      tocBTN.style.opacity = 0.45;
      tocBTN.style.paddingLeft = '1.1rem';
      tocHeading.style.opacity = 0;

    } else {
      tocBTN.style.opacity = 1;
      tocBTN.style.paddingLeft = '2rem';
      tocHeading.style.opacity = 1;
    }

  });

  const selectArticle = document.querySelector('#article');
  const dataSpyList = document.querySelectorAll('[data-bs-spy="scroll"]');

  function initializeScrollSpy(target) {
    const scrollSpyInstance = bootstrap.ScrollSpy.getInstance(selectArticle);

    if (scrollSpyInstance) {
      scrollSpyInstance.dispose();
      new bootstrap.ScrollSpy(selectArticle, {
        target: target,
      });
    }
  };

  const checkViewport = window.matchMedia("(max-width: 992px)");
  function updateScrollSpyTarget() {
    if (checkViewport.matches) {
      selectArticle.removeAttribute('data-bs-target');
      selectArticle.setAttribute('data-bs-target', '#list-of-contents-offcanvas');
      initializeScrollSpy('#list-of-contents-offcanvas');
    }

    checkViewport.onchange = (e) => {
      if (e.matches) {
        selectArticle.removeAttribute('data-bs-target');
        selectArticle.setAttribute('data-bs-target', '#list-of-contents-offcanvas');
        initializeScrollSpy('#list-of-contents-offcanvas');
      } else {
        selectArticle.removeAttribute('data-bs-target');
        selectArticle.setAttribute('data-bs-target', '#list-of-contents');
        initializeScrollSpy('#list-of-contents');
      }
    }
  };
  updateScrollSpyTarget();

  // Listen for viewport changes
  checkViewport.onchange = () => {
    updateScrollSpyTarget();
  };
});