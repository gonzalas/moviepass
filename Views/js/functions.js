function toggleRoom(id) {
    var accordionChild = document.getElementsByClassName('accordion-child'+id.toString());
    if (accordionChild[0].style.display == "none") {
        for (let i = 0; i < accordionChild.length; i++) {
            accordionChild[i].style.display = "block";
        }
        return;
    }

    if (accordionChild[0].style.display == "block") {
        for (let i = 0; i < accordionChild.length; i++) {
            accordionChild[i].style.display = "none";
        }
    }

}