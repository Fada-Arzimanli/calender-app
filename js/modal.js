var modal = document.getElementById("modal");


function openModal(num){
    modal.open = true;
    modal.classList.add("fade-in");
    switch(num) {
        case 1: data.current_modal_popup = 1; break;
        case 2: data.current_modal_popup = 2; break;
    }
}



function closeModal(){
    modal.open = false;
}


modal.addEventListener("animationend", function(){
    if(modal.classList.contains("fade-in")){
        modal.classList.remove("fade-in");
        switch(data.current_modal_popup) {
            case 1: renderFavColorPicker(); break;
            case 2: openPostIt(); break;
        }
    }
    
    if(modal.classList.contains("fade-out")){
        modal.classList.remove("fade-out");
        closeModal();
    }
});