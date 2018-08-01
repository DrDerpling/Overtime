/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./materialize/materialize.js');

//Modal setup
let modals = document.querySelectorAll('.modal');
if (modals instanceof NodeList) {
    let options = {};
    let instances = M.Modal.init(modals, options);
}

let inputs = document.querySelectorAll('.has-character-counter');
if (inputs instanceof NodeList) {
    let options = {};
    M.CharacterCounter.init(inputs);
}

let sidenav = document.querySelectorAll('.sidenav');
if (inputs instanceof NodeList) {
    let options = {'onOpenStart' : true};
    let instances = M.Sidenav.init(sidenav, options);
}