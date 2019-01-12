document.addEventListener('DOMContentLoaded', function() {
    // Enable SideBar
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {
        edge: 'right',
        draggable: 1
    });

    // Add character counter to inputs
    M.CharacterCounter.init(document.querySelectorAll('.counter'));
});
