// This gets called after the fade-in animation is finished, if the current_modal_popup is equal to 1.
function renderFavColorPicker(){
    var template = document.getElementById("fav-color");
    template.removeAttribute("hidden");
}



// This gets called when a color is clicked in the pick your color popup.
function updateColorData(name){
    removeCheckmarks();
    color_data.forEach(function(arr_data){
        if(name == arr_data.name){
            data.current_color.color = arr_data.color_code;
            data.current_color.off_color = arr_data.off_color_code;
            data.current_color.color_name = arr_data.name;
        }
    });
    addCheckmarkToCurrentColor();
}



// When this is called, the color immediately updates.  It gets called in updateColorClicked()
function changeColor(){
    ajax({color: data.current_color.color_name});
    var elements;
    elements = document.getElementsByClassName("color");
        for(i=0; i < elements.length; i++) {
          elements[i].style.backgroundColor = data.current_color.color;
    }
    
    elements = document.getElementsByClassName("border-color");
        for(i=0; i < elements.length; i++) {
          elements[i].style.borderColor = data.current_color.color;
    }
    
    elements = document.getElementsByClassName("off-color");
        for(i=0; i < elements.length; i++) {
          elements[i].style.color = data.current_color.off_color;
    }
}



// This is called when the Update button is clicked in the color popup.
function updateColorClicked(){
    changeColor();
    var template = document.getElementById("fav-color");
    template.setAttribute("hidden", "hidden");
    modal.classList.add("fade-out");
}



// This gets called in the updateColorData function.
function removeCheckmarks(){
    var checkmarks = document.getElementsByClassName("checkmark");
    for(let i = 0; i < checkmarks.length; i++){
        removeElement(checkmarks[i]);
    }
}



// This function takes in another element as the parameter, it removes that element from the document. Used in removeCheckmarks().
function removeElement(element){
    element.parentNode.removeChild(element);
}



// This is called when the page loads and in the updateColorData function.
function addCheckmarkToCurrentColor(){
    color_previews = document.getElementsByClassName("color-preview");
    
    for(let i = 0; i < color_previews.length; i++){
        if(color_previews[i].id == data.current_color.color_name){
            color_previews[i].innerHTML = "<i class='fas fa-check checkmark'></i>";
        }
    }
}