'use strict';


/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* Initialization  */
/**********************************************************************************************************************/
/**********************************************************************************************************************/


/***** SideNav */
let sidenavs = document.querySelectorAll('.sidenav');
for (var i = 0; i < sidenavs.length; i++){
    M.Sidenav.init(sidenavs[i]);
}





/***** Collapsible */
let collapsibles = document.querySelectorAll('.collapsible');
for (let i = 0; i < collapsibles.length; i++){
    M.Collapsible.init(collapsibles[i]);
}

/***** Modal */
let modals = document.querySelectorAll('.modal');
for (let i = 0; i < modals.length; i++){
    M.Modal.init(modals[i]);
}


/***** Tabs */
let tabs = document.querySelectorAll('.tabs');
for (let i = 0; i < tabs.length; i++){
    M.Tabs.init(tabs[i]);
}


/***** DropDown */
const DropOptions = {
    inDuration: 300,
    outDuration: 225,
    hover: true, // Activate on hover
    belowOrigin: true, // Displays dropdown below the button
    alignment: 'right'
};

let ElemDropDown = document.querySelectorAll('.dropdown-trigger');
for (let i = 0; i < ElemDropDown.length; i++){
    M.Dropdown.init(ElemDropDown[i], DropOptions);
}


/***** Paralax */
let paralax = document.querySelectorAll('.paralax');
for (let i = 0; i < paralax.length; i++){
    M.Parallax.init(paralax[i]);
}


/***** Carrousel */
// let CarouselOptions = {
//     indicators : true,
//     fullWidth : true,
//     duration : 150
// };

// let carousel = document.querySelectorAll('.carousel');
// for (let i = 0; i < carousel.length; i++){
//     M.Parallax.init(carousel[i]), CarouselOptions;
// } 

// let carouselElem = document.querySelectorAll('.carousel');

// setTimeout(()=>{
//     M.Carousel.getInstance(carouselElem[0]).next();
//  },3000);




window.onload = function() {
    initCarousel('.carousel', {
      fullWidth: true,
      indicators: true,
      autoScroll: 6000 // time in ms
    });
  }
  
  function initCarousel(elms, opts) {
    if (!window || !document) return null;
  
    const instances = M.Carousel.init(getElements(elms), opts);
  
    if (Array.isArray(instances)) {
      for (let i = 0; i < instances.length; ++i) {
        addAutoScroll(instances[i]);
      }
    } else {
      addAutoScroll(instances);
    }
  
    return instances;
  }
  
  function destroyCarousel(instances) {
    if (!window || !document) return null;
  
    if (Array.isArray(instances)) {
      for (let i = 0; i < instances.length; ++i) {
        removeAutoScroll(instances[i]);
        instances[i].destroy();
      }
    } else {
      removeAutoScroll(instances);
      instances.destroy();
    }
  }
  
  function addAutoScroll(instance) {
    if (!instance.options.autoScroll) return;
  
    instance.autoScrollIntervalId = window.setInterval(() => {
      instance.next();
    }, instance.options.autoScroll);
  
    instance.el.addEventListener("mouseover", carouselMouseOverTouchStart, {
      passive: true
    });
    instance.el.addEventListener("mouseleave", carouselMouseOutTouchEnd, {
      passive: true
    });
    instance.el.addEventListener("touchstart", carouselMouseOverTouchStart, {
      passive: true
    });
    instance.el.addEventListener("touchend", carouselMouseOutTouchEnd, {
      passive: true
    });
  }
  
  function removeAutoScroll(instance) {
    if (instance.autoScrollIntervalId) {
      window.clearInterval(instance.autoScrollIntervalId);
      instance.autoScrollIntervalId = undefined;
    }
  
    instance.el.removeEventListener("mouseover", carouselMouseOverTouchStart);
    instance.el.removeEventListener("mouseleave", carouselMouseOutTouchEnd);
    instance.el.removeEventListener("touchstart", carouselMouseOverTouchStart);
    instance.el.removeEventListener("touchend", carouselMouseOutTouchEnd);
  }
  
  function carouselMouseOverTouchStart() {
    const instance = M.Carousel.getInstance(this);
    if (!instance) return;
  
    if (instance.autoScrollIntervalId) {
      window.clearInterval(instance.autoScrollIntervalId);
      instance.autoScrollIntervalId = undefined;
    }
  }
  
  function carouselMouseOutTouchEnd() {
    const instance = M.Carousel.getInstance(this);
    if (!instance) return;
  
    if (!instance.autoScrollIntervalId) {
      instance.autoScrollIntervalId = window.setInterval(() => {
        instance.next();
      }, instance.options.autoScroll);
    }
  }
  
  // if searching for an element by id, insert a # in front of the passed in id
  function getElements(elms) {
    if (elms.charAt(0) === "#") {
      elms = elms.replace("#", "");
      return document.getElementById(elms);
    }
  
    return document.querySelectorAll(elms);
  }
