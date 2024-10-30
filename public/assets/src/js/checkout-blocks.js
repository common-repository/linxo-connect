const settings	= window.wc.wcSettings.getSetting( 'linxo_woo_data', {} );
const methods	= settings.methods;

function Label({ label, icon }) {
    return (
        <span className='wc-block-payment-method__label' style={{ width: '100%' }}>
            {label}
            <img src={icon} alt={label} className='wc-block-payment-method__image' style={{ float: 'right', marginRight: '20px' }} />
        </span>
    );
}

function Description({description}) {
    return (
        <div className='wc-block-payment-method__description' dangerouslySetInnerHTML={{ __html: description }} ></div>
    );
}

methods.forEach( method => {

	const params = {
		name: method.name,
		label: Label(method),
		content: Description(method),
		edit: Description(method),
		canMakePayment: () => true,
		ariaLabel: method.label
	};
	window.wc.wcBlocksRegistry.registerPaymentMethod( params );
});


document.addEventListener('DOMContentLoaded', function() {

    const displayWcNotice = () => {

        const container = document.querySelector('.wc-block-components-notices');

        container.addEventListener('click', function(e) {

            const closebtn = e.target.closest('.wc-block-components-notice-banner__dismiss');

            if (closebtn) {
                closebtn.closest('.wc-block-components-notice-banner').remove();
            }
        });
    
        let formData = new FormData();
        formData.append('nonce', linxo_data.nonce);
        formData.append('action', 'linxo_woo_check_wc_notice');
    
        fetch( linxo_data.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            
            if (res.success) {
                let notices = res.data;

                for (var key in notices) {

                    let notice  = notices[key];

                    let noticeHtml = `
                        <div class="wc-block-store-notice wc-block-components-notice-banner is-error is-dismissible">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M12 3.2c-4.8 0-8.8 3.9-8.8 8.8 0 4.8 3.9 8.8 8.8 8.8 4.8 0 8.8-3.9 8.8-8.8 0-4.8-4-8.8-8.8-8.8zm0 16c-4 0-7.2-3.3-7.2-7.2C4.8 8 8 4.8 12 4.8s7.2 3.3 7.2 7.2c0 4-3.2 7.2-7.2 7.2zM11 17h2v-6h-2v6zm0-8h2V7h-2v2z"></path></svg>
                            <div class="wc-block-components-notice-banner__content">
                                <div>${notice['notice']}</div>
                            </div>
                            <button type="button" class="components-button wc-block-components-button wp-element-button wc-block-components-notice-banner__dismiss contained has-text has-icon">
                                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg>
                                <span class="wc-block-components-button__text"></span>
                            </button>
                        </div>
                    `;

                    container.insertAdjacentHTML('beforeend', noticeHtml);
                }
            }
        });
    
    };

    if ( linxo_data.action === 'failed' ) {
        displayWcNotice();
    }
});