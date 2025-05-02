window.onload = () => {
    var bot = document.querySelector("#boton")
    var sp = document.querySelector("#spDiv")
    var en = document.querySelector("#enDiv")
    var spFooter = document.querySelector("#spFooter")
    var enFooter = document.querySelector("#enFooter")
   

    bot.addEventListener('click', function() {
        if (en.style.display === "block") {     //Español a Ingles
            sp.style.display = "block"
            en.style.display = "none"
            spFooter.style.display = "block"
            enFooter.style.display = "none"
            enHeader.style.display = "none"
            spHeader.style.display = "block"
        } else {                                //Ingles a Español
            sp.style.display = "none"
            enDiv.style.display = "block"
            spFooter.style.display = "none"
            enFooter.style.display = "block"
            spHeader.style.display = "none"
            enHeader.style.display = "block"
        }
    })

   
}
