const Iban = () => {

    const addNewBtn     = document.querySelector( '#JS-LINXO-iban-add-new-btn' );
    const accountsBlock = document.querySelector( '#JS-LINXO-iban-accounts' );
    const addNewBlock   = document.querySelector( '#JS-LINXO-iban-add-new' );
    const footer        = document.querySelector( '#JS-LINXO-iban-footer' );
    const typeCompany   = document.querySelector( '#JS-LINXO-iban-type-company' );
    const typePersone   = document.querySelector( '#JS-LINXO-iban-type-person' );
    const companyTable  = document.querySelector( '#JS-LINXO-iban-add-new-company' );
    const personTable   = document.querySelector( '#JS-LINXO-iban-add-new-person' );
    const ibanInputs    = document.querySelectorAll( '.JS-linxo-input-iban' );

    if ( addNewBtn ) {

        addNewBtn.addEventListener( 'click', (e) => {
            e.preventDefault();

            jQuery( accountsBlock ).hide();
            jQuery( addNewBlock ).show();
            jQuery( footer ).show();
        });
    }

    if ( typeCompany ) {

        typeCompany.addEventListener( 'change', (e) => {
            jQuery( companyTable ).show();
            jQuery( personTable ).hide();
        });
    }

    if ( typePersone ) {

        typePersone.addEventListener( 'change', (e) => {
            jQuery( personTable ).show();
            jQuery( companyTable ).hide();
        });
    }

    if ( ibanInputs ) {

        ibanInputs.forEach( input => {

            input.addEventListener( 'change', (e) => {
                let value = e.target.value;
                value = value.replace(/\s/g, '');
                e.target.value = value;
            });
        });
    }

};
document.addEventListener( 'DOMContentLoaded', (e) => Iban(e) );