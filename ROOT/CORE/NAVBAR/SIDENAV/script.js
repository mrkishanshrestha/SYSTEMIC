
document.addEventListener("DOMContentLoaded", function(event) { 


    const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");

        sidebar.addEventListener("mouseover" , () =>{
            sidebar.classList.remove("close");
        })
        
        sidebar.addEventListener("mouseout" , () =>{
            sidebar.classList.add("close");
        })
            
        sidebar.addEventListener("click" , () =>{
        sidebar.classList.remove("close");
})


});


function changeDash(newSrc) {
    var dashframe = document.getElementById("dash-frame");
    dashframe.src=newSrc;
}

