/**
 * SECTION : uteis
 *      This section will inherited for Other javascript files, it contais functions with a specific return
 */





/*
    Name        : FisEmpty;
    Objective   : Check if the content is a valid content.
    @Params     : (e) e : content to check.
    @Output     : (boolean)
    Author      : Ricardo Scarpim
    Date        : 10/11/2019
*/
export const FisEmpty = (e) => {

    switch (e) {
        case "":
        case 0:
        case "0":
        case null:
        case false:
        case typeof this == "undefined":
            return true;
        default:
            return false;
    }
};




/*
    Name        : FValidateFomr;
    Objective   : Check the Form to Validate.
    @Params     : pDomForm.
    @Output     : 
    Author      : Ricardo Scarpim
    Date        : 10/11/2019
*/
export const FValidateForm = (pDomForm) => {

    /* Selecting the Form Fields. */
    const vElements = pDomForm.querySelectorAll('form, input, select-one, select, select-one, checkbox');

    /* Variables. */
    let vToContinue = true;

    /* Search the Form for the following fields. */
    for(let i = 0, elem; elem = vElements[i++];) {

        /* Switching According with the Element Type. */
        switch (elem.type) {

            /* Input Type Text. */
            case 'text':
                
                /* Function to check if the element contains any data. */
                if(FisEmpty(elem.value)){

                    /* Execute until is true. */
                    switch (true) {

                        /* If element contais the class required. */
                        case elem.classlist.contains('required'):
                        console.log(elem.getAttribute('id'))
                        break;
                    }

                    vToContinue = false
                }
                break

            /* Input Type Email. */
            case 'email':

                /* Function to check if the element contains any data. */
                if(FisEmpty(elem.value)){

                    console.log(elem.getAttribute('name'))

                    vToContinue = false
                }
                break

            /* Input Type Password. */
            case 'password':
                
                break

            /* Input Type Select-One */
            case 'select-one':
                console.log(elem.type)
                break

            /* Input Type Checkbox */
            case 'checkbox':
                console.log(elem.type)
                break

        }
    };

    return vToContinue;
};

