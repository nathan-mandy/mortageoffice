(()=>{var t,e,n,o,r={933:()=>{document.addEventListener("click",(function(t){const{FWP:e}=window;void 0!==e&&e&&"a"===t.target.tagName.toLowerCase()&&t.target.classList.contains("facetwp-page")&&t.target.href&&"#"!=t.target.href&&t.preventDefault()}))},806:()=>{document.addEventListener("click",(function(t){const e=t.target.closest(".go-back");if(e)return t.preventDefault(),function(t,e){const n=e.closest(".sub-menu.active");if(n)return n.classList.remove("active"),!1}(0,e)}))},112:()=>{!function(t,e,n,o){"use strict";function r(e,n){this.element=e,this.settings=t.extend({},s,n),this._defaults=s,this._name=i,this.init()}var i="doubleTapToGo",s={automatic:!0,selectorClass:"doubletap",selectorChain:"li:has(ul)"};t.extend(r.prototype,{preventClick:!1,currentTap:t(),init:function(){t(this.element).on("touchstart","."+this.settings.selectorClass,this._tap.bind(this)).on("click","."+this.settings.selectorClass,this._click.bind(this)).on("remove",this._destroy.bind(this)),this._addSelectors()},_addSelectors:function(){!0===this.settings.automatic&&t(this.element).find(this.settings.selectorChain).addClass(this.settings.selectorClass)},_click:function(e){this.preventClick?e.preventDefault():this.currentTap=t()},_tap:function(e){var n=t(e.target).closest("li");return n.hasClass(this.settings.selectorClass)?n.get(0)===this.currentTap.get(0)?void(this.preventClick=!1):(this.preventClick=!0,this.currentTap=n,void e.stopPropagation()):void(this.preventClick=!1)},_destroy:function(){t(this.element).off()},reset:function(){this.currentTap=t()}}),t.fn[i]=function(e){var n,s=arguments;return e===o||"object"==typeof e?this.each((function(){t.data(this,i)||t.data(this,i,new r(this,e))})):"string"==typeof e&&"_"!==e[0]&&"init"!==e?(this.each((function(){var o=t.data(this,i),a="destroy"===e?"_destroy":e;o instanceof r&&"function"==typeof o[a]&&(n=o[a].apply(o,Array.prototype.slice.call(s,1))),"destroy"===e&&t.data(this,i,null)})),n!==o?n:this):void 0}}(jQuery,window,document)}},i={};function s(t){var e=i[t];if(void 0!==e)return e.exports;var n=i[t]={exports:{}};return r[t].call(n.exports,n,n.exports,s),n.exports}s.m=r,e=Object.getPrototypeOf?t=>Object.getPrototypeOf(t):t=>t.__proto__,s.t=function(n,o){if(1&o&&(n=this(n)),8&o)return n;if("object"==typeof n&&n){if(4&o&&n.__esModule)return n;if(16&o&&"function"==typeof n.then)return n}var r=Object.create(null);s.r(r);var i={};t=t||[null,e({}),e([]),e(e)];for(var a=2&o&&n;"object"==typeof a&&!~t.indexOf(a);a=e(a))Object.getOwnPropertyNames(a).forEach((t=>i[t]=()=>n[t]));return i.default=()=>n,s.d(r,i),r},s.d=(t,e)=>{for(var n in e)s.o(e,n)&&!s.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:e[n]})},s.f={},s.e=t=>Promise.all(Object.keys(s.f).reduce(((e,n)=>(s.f[n](t,e),e)),[])),s.u=t=>t+".js",s.miniCssF=t=>{},s.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(t){if("object"==typeof window)return window}}(),s.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),n={},o="skeletor-core:",s.l=(t,e,r,i)=>{if(n[t])n[t].push(e);else{var a,c;if(void 0!==r)for(var u=document.getElementsByTagName("script"),d=0;d<u.length;d++){var l=u[d];if(l.getAttribute("src")==t||l.getAttribute("data-webpack")==o+r){a=l;break}}a||(c=!0,(a=document.createElement("script")).charset="utf-8",a.timeout=120,s.nc&&a.setAttribute("nonce",s.nc),a.setAttribute("data-webpack",o+r),a.src=t),n[t]=[e];var f=(e,o)=>{a.onerror=a.onload=null,clearTimeout(h);var r=n[t];if(delete n[t],a.parentNode&&a.parentNode.removeChild(a),r&&r.forEach((t=>t(o))),e)return e(o)},h=setTimeout(f.bind(null,void 0,{type:"timeout",target:a}),12e4);a.onerror=f.bind(null,a.onerror),a.onload=f.bind(null,a.onload),c&&document.head.appendChild(a)}},s.r=t=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},(()=>{var t;s.g.importScripts&&(t=s.g.location+"");var e=s.g.document;if(!t&&e&&(e.currentScript&&(t=e.currentScript.src),!t)){var n=e.getElementsByTagName("script");if(n.length)for(var o=n.length-1;o>-1&&(!t||!/^http(s?):/.test(t));)t=n[o--].src}if(!t)throw new Error("Automatic publicPath is not supported in this browser");t=t.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),s.p=t})(),(()=>{var t={792:0};s.f.j=(e,n)=>{var o=s.o(t,e)?t[e]:void 0;if(0!==o)if(o)n.push(o[2]);else{var r=new Promise(((n,r)=>o=t[e]=[n,r]));n.push(o[2]=r);var i=s.p+s.u(e),a=new Error;s.l(i,(n=>{if(s.o(t,e)&&(0!==(o=t[e])&&(t[e]=void 0),o)){var r=n&&("load"===n.type?"missing":n.type),i=n&&n.target&&n.target.src;a.message="Loading chunk "+e+" failed.\n("+r+": "+i+")",a.name="ChunkLoadError",a.type=r,a.request=i,o[1](a)}}),"chunk-"+e,e)}};var e=(e,n)=>{var o,r,[i,a,c]=n,u=0;if(i.some((e=>0!==t[e]))){for(o in a)s.o(a,o)&&(s.m[o]=a[o]);c&&c(s)}for(e&&e(n);u<i.length;u++)r=i[u],s.o(t,r)&&t[r]&&t[r][0](),t[r]=0},n=self.webpackChunkskeletor_core=self.webpackChunkskeletor_core||[];n.forEach(e.bind(null,0)),n.push=e.bind(null,n.push.bind(n))})(),(()=>{"use strict";function t(t){if(!t)return!1;"#"===t.substring(0,1)&&(t=t.substring(1)),function(t){if(!t)return!1;t.scrollIntoView({behavior:"smooth"})}(document.getElementById(t))}function e(t){s.e(317).then(s.t.bind(s,317,23)).then((e=>{new(0,e.default)(t,{onPin:()=>{const t=document.body;t.classList.add("headroom-pinned"),t.classList.remove("headroom-unpinned")},onUnpin:()=>{const t=document.body;t.classList.add("headroom-unpinned"),t.classList.remove("headroom-pinned")}}).init()}))}function n(t){const[,e,n,o,r]=t.match(/rgba?\((\d{1,3}), ?(\d{1,3}), ?(\d{1,3}),? ?(\d{1,3})?\)?/);return{r:e,g:n,b:o,a:r}}function o(t){const e=document.getElementById("main")?.children[0];e&&function(t){const e=function(t){const{a:e}=n(t);return void 0===e?1:e}(t),o=function(t){const{r:e,g:o,b:r}=n(t);return.299*e+.587*o+.114*r}(t);return e*(255-o)>=128}(window.getComputedStyle(e).backgroundColor)&&t.classList.add("dark-background")}function r(t,e,n){var o;return function(){var r=this,i=arguments,s=n&&!o;clearTimeout(o),o=setTimeout((function(){o=null,n||t.apply(r,i)}),e),s&&t.apply(r,i)}}function i(t){const e=document.getElementById("main"),n=getComputedStyle(e).paddingLeft,o=parseInt(n),r=window.innerWidth-o,i=window.innerWidth-2*o;t.forEach((t=>{const e=t.getBoundingClientRect(),n=parseInt(t.style.getPropertyValue("--offsetX"))||0;if(e.width>i)return;const o=Math.max(0,e.right-n-r);t.style.setProperty("--offsetX",-1*o+"px")}))}document.addEventListener("click",(function(e){if("a"!==e.target.tagName.toLowerCase())return!1;!function(e){const n=e.target,o=n.hash;o&&!("ignoreAnchorScroll"in n.dataset)&&n.hostname===window.location.hostname&&n.pathname===window.location.pathname&&o&&(e.preventDefault(),t(o))}(e)})),window.addEventListener("hashchange",(function(){const e=window.location.hash;if(!e)return!1;t(e)})),document.addEventListener("DOMContentLoaded",(function(){const t=document.getElementById("header");t&&function(t,...e){e.forEach((e=>e(t)))}(t,e,o)})),document.addEventListener("click",(function(t){t.target.classList.contains("search-toggle")&&t.target.closest(".header-search").classList.toggle("activated")})),s(933),window.jQuery,document.addEventListener("click",(function(t){if(t.target.closest(".main-menu-toggle"))return t.preventDefault(),document.body.classList.toggle("nav-open"),document.body.classList.contains("nav-open")||document.querySelectorAll(".sub-menu.active").forEach((t=>t.classList.remove("active"))),!1})),window.addEventListener("resize",r((function(){document.body.classList.remove("nav-open")}),100)),s(806),document.addEventListener("DOMContentLoaded",(function(){const t=document.querySelectorAll(".sub-menu");t&&(i(t),window.addEventListener("resize",r((()=>{i(t)}),100)))})),document.addEventListener("click",(function(t){const e=t.target.closest(".sub-menu-toggle");if(e)return t.preventDefault(),function(t,e){const n=e.closest(".menu-item");if(!n)return;const o=n.querySelector(".sub-menu");if(!o)return;let r=e.getAttribute("aria-expanded");return r=r&&"false"!==r?"false":"true",e.setAttribute("aria-expanded",r),o.classList.toggle("active"),!1}(0,e)})),window.addEventListener("resize",r((function(){document.querySelectorAll(".sub-menu.active").forEach((t=>{t.classList.remove("active")}))}),100));const a=window.wp.hooks;s(112),document.addEventListener("DOMContentLoaded",(function(){const{jQuery:t}=window;if(!t)return;const e=(0,a.applyFilters)("skeletor.doubleTapToGo.menuSelector","#main-menu"),n=(0,a.applyFilters)("skeletor.doubleTapToGo.selectorChain","li.menu-item-has-children:has(ul)");t(e).doubleTapToGo({selectorChain:n})}))})()})();