var view_modal = document.getElementById("view-entry-modal");

// Get the button that opens the modal
var btn = document.getElementById("view-entry-btn");

// Get the <span> element that closes the modal
var view_span = document.getElementsByClassName("view-close")[0];

// When the user clicks the button, open the modal 
function viewentry() {
    view_modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
view_span.onclick = function() {
    view_modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == view_modal) {
        view_modal.style.display = "none";
    }
}