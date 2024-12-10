document.addEventListener('DOMContentLoaded', function() {
    const node = document.querySelector(".header-search"); 
    const textnode = document.querySelector(".utility-menu-wrapper"); 
    if (node && textnode) {
      node.appendChild(textnode); 
    }
  });