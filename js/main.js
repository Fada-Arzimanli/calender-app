function removeClass(elem, className){
    if(elem.classList.contains(className)){
        elem.classList.remove(className);
    }
}


function removeAttribute(elem, attrName){
    if(elem.hasAttribute(attrName)){
        elem.removeAttribute(attrName);
    }
}