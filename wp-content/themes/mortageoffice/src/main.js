document.addEventListener('DOMContentLoaded', function() {
    const node = document.querySelector(".header-search"); 
    const textnode = document.querySelector(".utility-menu-wrapper"); 
    if (node && textnode) {
      node.appendChild(textnode); 
    }
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const utility = document.querySelector('.header-search');
    const button = document.querySelector('.form-button');
    const nav = document.querySelector('.main-menu');  
    
    if (utility && button) {  
        if (window.innerWidth <= 1024) {
            utility.appendChild(button);  
        }
    }
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 1024) {
            if (utility && button && !utility.contains(button)) {
                utility.appendChild(button);  
            }
        } else {
            if (nav && button && !nav.contains(button)) {
                nav.appendChild(button);  
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
  const nodes = document.querySelector(".utility-menu"); 
  const textnodes = document.querySelector(".search-form-wrapper"); 
  const textnodes1 = document.querySelector(".search-toggle"); 
  const header = document.querySelector('.header-search');  

  // Function to append elements based on window size
  function appendElements() {
    if (window.innerWidth <= 1024) {
      // If window is 1024px or less, append to utility-menu
      if (nodes && textnodes && textnodes1) {
        nodes.appendChild(textnodes);  // Append search-form-wrapper
        nodes.appendChild(textnodes1); // Append search-toggle
      }
    } else {
      // If window is greater than 1024px, append to header-search
      if (header && textnodes && textnodes1) {
        header.appendChild(textnodes);  // Append search-form-wrapper
        header.appendChild(textnodes1); // Append search-toggle
      }
    }
  }

  // Initial check when the DOM is ready
  appendElements();

  // Add a resize event listener to handle changes dynamically
  window.addEventListener('resize', function() {
    appendElements(); // Recheck on resize
  });
});

