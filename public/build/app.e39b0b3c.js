(self.webpackChunk=self.webpackChunk||[]).push([[524],{4028:(e,t,s)=>{"use strict";s(6757),s(1035),s(38),s(9744),s(9705)},38:()=>{var e=document.querySelector(".dropdown"),t=document.querySelector(".dropdown-menu");e.addEventListener("click",(function(){e.classList.contains("active")?(e.classList.remove("active"),t.classList.add("close")):(e.classList.add("active"),t.classList.remove("close"))}))},6757:()=>{var e=document.getElementById("navbar");document.getElementById("nav-button").addEventListener("click",(function(){e.classList.contains("close")?e.classList.remove("close"):e.classList.add("close")}))},1035:(e,t,s)=>{s(1629),s(3418),s(9432),s(6099),s(7764),s(3500);var n=document.querySelector(".canvas-form"),c=document.querySelector(".btn-close"),r=document.getElementById("form-container"),o=document.getElementById("response-container"),a=document.getElementById("response-content");function i(){n.classList.add("close")}function d(e){e.preventDefault(),n.classList.remove("close");var t=e.srcElement.href,s=new XMLHttpRequest;s.open("GET",t),s.send(),s.onreadystatechange=function(){r.innerHTML=s.response,document.querySelectorAll("form").forEach((function(e){e.addEventListener("submit",l)}))}}function l(e){e.preventDefault();var t=e.target.getAttribute("action"),s=new XMLHttpRequest,n=new FormData(this);s.open("POST",t),s.send(n),s.onreadystatechange=function(){var e=JSON.parse(this.responseText).status,t=JSON.parse(this.responseText).message;"success"===e&&(o.classList.add("success"),o.classList.remove("error")),"error"===e&&(o.classList.add("error"),o.classList.remove("success")),o.classList.remove("hidden"),a.textContent=t;var s=JSON.parse(this.responseText).elements;Object.keys(s).forEach((function(e){var t=s[e].id,n=s[e].view;document.getElementById(t).innerHTML=n,i()}))}}Array.from(document.getElementsByClassName("open-canvas")).forEach((function(e){e.addEventListener("click",d)})),c.addEventListener("click",i),o.addEventListener("mouseover",(function(){o.classList.add("hidden"),o.classList.remove("success"),o.classList.remove("error")}))},9705:(e,t,s)=>{s(1629),s(9432),s(6099),s(3500);var n=document.getElementById("generate-payment"),c=document.getElementById("response-container"),r=document.getElementById("response-content");n.addEventListener("click",(function(e){e.preventDefault();var t=e.srcElement.href,s=new XMLHttpRequest;console.log(t),s.open("GET",t),s.send(),s.onreadystatechange=function(){var e=JSON.parse(s.responseText),t=e.status,n=e.message,o=e.elements;console.log(e),"success"===t&&(c.classList.add("success"),c.classList.remove("error")),"error"===t&&(c.classList.add("error"),c.classList.remove("success")),c.classList.remove("hidden"),r.textContent=n,Object.keys(o).forEach((function(e){var t=o[e].id,s=o[e].view;document.getElementById(t).innerHTML=s}))}}))},9744:(e,t,s)=>{s(1629),s(6099),s(3500);var n=document.querySelectorAll(".btn-dual"),c=document.querySelectorAll(".dual");n.forEach((function(e,t){e.addEventListener("click",(function(){n.forEach((function(e){return e.classList.remove("active")})),e.classList.add("active"),c.forEach((function(e){return e.classList.add("close")})),c[t].classList.remove("close")}))}))}},e=>{e.O(0,[717],(()=>{return t=4028,e(e.s=t);var t}));e.O()}]);