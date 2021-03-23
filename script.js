function expand(elem) {
    elem.style.display = (elem.style.display == "none") ? "contents" : "none";
    $(elem).next().toggleClass('expanded');
}

function read_toggle(id, more, less) {
    el = document.getElementById("readmore-link" + id);
    el.innerHTML = (el.innerHTML == more) ? less : more;
    expand(document.getElementById("readmore-div" + id));
}