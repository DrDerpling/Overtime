/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./materialize/materialize.js');

//Modal setup
var elems = document.querySelectorAll('.modal');
if (elems instanceof NodeList) {
    var options = {};
    var instances = M.Modal.init(elems, options);
}


