const myAccount = () => {

    const demoSandbox       = document.querySelector('#JS-LINXO-account-demo-sandbox');
    const demoProduction    = document.querySelector('#JS-LINXO-account-demo-production');
    const demoTable         = document.querySelector('#JS-LINXO-account-sandbox');
    const prodTable         = document.querySelector('#JS-LINXO-account-prod');
    const passwordInputs    = document.querySelectorAll('.password-input');
    const selectLogFile     = document.querySelector('#JS-LINXO-account-select-log-file');
    const buttonDwnLogFile  = document.querySelector('#JS-LINXO-account-button-dwn-log-file');

    /**
     * Show sandbox
     */
    function showSandbox(e) {

        jQuery( prodTable ).hide();
        jQuery( demoTable ).show();
    }

    /**
     * Show production
     */
    function showProduction(e) {

        jQuery( prodTable ).show();
        jQuery( demoTable ).hide();
    }

    /**
     * Toggle password visibility
     */
    function togglePassword( e, item ) {

        let show    = e.target.closest('.password-input__show');
        let hide    = e.target.closest('.password-input__hide');
        let input   = item.querySelector('input');

        if ( show ) {

            input.setAttribute( 'type', 'text' );
            item.classList.remove('show');

        } else if ( hide ) {

            input.setAttribute( 'type', 'password' );
            item.classList.add('show');
        }
    }

    /**
     * Change button download log file value
     */
    function changeButtonDwnLogFileValue(e) {

        let selectValue = e.currentTarget.value;

        if ( selectValue && buttonDwnLogFile ) {

            buttonDwnLogFile.dataset.href = selectValue;
        }
    }

    /**
     * Get file content
     */
    function getFileContent(e) {
        e.preventDefault();

        let target      = e.currentTarget;
        let spinner     = target.querySelector('.spinner');
        let fileName    = target.dataset.href;

        spinner.classList.add('is-active');

        let formData    = new FormData();
        formData.append( 'action', 'linxo_woo_get_log_file_content' );
        formData.append( 'nonce', LINXO_WOO_ADMIN_MAIN_SETTINGS_DATA.nonce );
        formData.append( 'name', fileName );

        let requestOptions = {
            method: 'POST',
            body: formData,
            redirect: 'follow'
        };

        fetch(LINXO_WOO_ADMIN_MAIN_SETTINGS_DATA.ajaxUrl, requestOptions)
        .then(response => response.json())
        .then(result => {

            if ( result.success ) {

                let data = new Blob( [result.data] );
                let aElement = document.createElement('a');
                aElement.setAttribute('download', fileName);
                let href = URL.createObjectURL(data);
                aElement.href = href;
                aElement.setAttribute('target', '_blank');
                aElement.click();
                URL.revokeObjectURL(href);

            } else {

                console.log( result.data );
            }

            spinner.classList.remove('is-active');

        })
        .catch(error => {
            console.log( 'ERROR: ', error );
        });

    }

    if ( demoSandbox ) {
        demoSandbox.addEventListener( 'change', (e) => showSandbox(e) );
    }

    if ( demoProduction ) {
        demoProduction.addEventListener( 'change', (e) => showProduction(e) );
    }

    passwordInputs.forEach( input => {
        input.addEventListener( 'click', (e) => togglePassword(e, input) );
    });

    if ( selectLogFile ) {
        selectLogFile.addEventListener( 'change', (e) => changeButtonDwnLogFileValue(e) );
    }

    if ( buttonDwnLogFile ) {
        buttonDwnLogFile.addEventListener( 'click', (e) => getFileContent(e) );
    }

};

document.addEventListener( 'DOMContentLoaded', () => myAccount() );