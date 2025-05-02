window.onload = () => {

    var botonsql = document.querySelector("#SQL")
    var pre = document.querySelector("#pre")


    botonsql.addEventListener('click', function(){
     if( pre.style.display === "flex"){
            pre.style.display = "none"
        }else{
            pre.style.display = "flex"
        }
    })

}