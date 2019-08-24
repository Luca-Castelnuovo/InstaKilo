function materialize_init() {
    // Enable SideBar
    var sidenav = M.Sidenav.init(document.querySelectorAll(".sidenav"), {
        edge: "right",
        draggable: 1
    });

    // Add character counter to inputs
    M.CharacterCounter.init(document.querySelectorAll(".counter"));

    // Enable MaterialBox
    var materialbox = M.Materialbox.init(
        document.querySelectorAll(".materialboxed"), {}
    );

    // Tooltip
    var tooltips = M.Tooltip.init(document.querySelectorAll(".tooltipped"), {});

    // Modals
    var modals = M.Modal.init(document.querySelectorAll(".modal"), {});
}

document.addEventListener("DOMContentLoaded", function() {
    yall({
        observeChanges: true,
        idlyLoad: true
    });

    if (typeof auto_init === "undefined" || !auto_init) {
        materialize_init();
    }
});
