const Faq = (e) => {

    const items = document.querySelectorAll( '.linxo-woo__tabs-content__tab__form__body__faq__item' );

    if ( items ) {

        items.forEach( (item) => {

            item.addEventListener( 'click', (e) => {

                const title = e.target.closest( '.linxo-woo__tabs-content__tab__form__body__faq__item__header' );

                if ( title ) {

                    const body = title.nextElementSibling;

                    if ( item.classList.contains( 'active' ) ) {

                        jQuery( body ).hide();
                        item.classList.remove( 'active' );

                    } else {

                        jQuery( body ).show();
                        item.classList.add( 'active' );
                    }
                }
            });
        });
    }

}
document.addEventListener( 'DOMContentLoaded', (e) => Faq(e) );