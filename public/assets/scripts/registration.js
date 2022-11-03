'use strict';

/**
 * SECTION : Registration
 *      Sections Created:
 * 
 *          1 - Section Registration Form 
 */


/**
 *  Importing the uteis.
 */

import {FValidateForm}
        from './uteis';


/* Add to the DOM the click event. */
document.body.addEventListener('click', function(e){

    /* Checking the OBJ by id */
    switch (e.target.id){

        /* Button Save the New User. */
        case 'btn-register':
            
            /* Checking if the Value is Valid */
            if(!FValidateForm(document.getElementById('FrmRegister'))){

                e.preventDefault();

                console.log('invalid form')
            }
            break;
    }
})