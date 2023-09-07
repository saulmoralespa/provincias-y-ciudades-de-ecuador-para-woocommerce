(function($){

    let sizesContainer = $('#filters_by_cities_shipping_method_rules_shipping_methods');

    let cont = 0;

    sizesContainer.find('.add').click(function (){

        cont++;

        let fieldBoxSize = `<tr>
                                <td><input type="checkbox" class="chosen_box"></td>
                                <td><input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[${cont}][min]" class="input-text regular-input wc_input_decimal" required></td>
                                <td><input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[${cont}][max]" class="input-text regular-input wc_input_decimal" required></td>
                                <td><input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[${cont}][additional_cost]" class="input-text regular-input wc_input_decimal" required></td>
                            </tr>`;
        sizesContainer.find('tbody').append(fieldBoxSize);
    });


    sizesContainer.on('click', '.remove', function (){

        sizesContainer.find('.chosen_box:checked').each(function () {
            $(this).parent().parent('tr').remove();
        })
    });


})(jQuery);