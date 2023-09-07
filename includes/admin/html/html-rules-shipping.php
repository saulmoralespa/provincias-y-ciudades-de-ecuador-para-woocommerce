<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$method_rules_settings = $this->get_option( 'rules', [] );

$rows = <<<HTML
<tr>
    <td>
        <input type="checkbox" class="chosen_box">
    </td>
    <td>
        <input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[0][min]" value="" class="input-text regular-input wc_input_decimal" required>
    </td>
    <td>
        <input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[0][max]" value="" class="input-text regular-input wc_input_decimal" required>
    </td>
    <td>
        <input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[0][additional_cost]" value="" class="input-text regular-input wc_input_decimal" required>
    </td>
</tr>
HTML;

if (!empty($method_rules_settings)){
    $rows = '';
    foreach ($method_rules_settings as  $key => $method_rules_setting){
        $rows .= <<<HTML
<tr>
    <td>
        <input type="checkbox" class="chosen_box">
    </td>
    <td>
        <input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[$key][min]" value="{$method_rules_setting['min']}" class="input-text regular-input wc_input_decimal" required>
    </td>
    <td>
        <input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[$key][max]" value="{$method_rules_setting['max']}" class="input-text regular-input wc_input_decimal" required>
    </td>
    <td>
        <input type="text" name="woocommerce_filters_by_cities_shipping_method_rules[$key][additional_cost]" value="{$method_rules_setting['additional_cost']}" class="input-text regular-input wc_input_decimal" required>
    </td>
</tr>
HTML;
    }
}


?>

<table>
    <tr id="<?php echo $this->id; ?>_rules_shipping_methods">
        <td class="titledesc" colspan="2">
            <strong>Reglas de cálculo</strong>
            <table class="widefat">
                <thead>
                <tr>
                    <th>
                        <input type="checkbox"/>
                    </th>
                    <th>Peso mínimo</th>
                    <th>Peso máximo</th>
                    <th>Costo adicional</th>
                </tr>
                </thead>
                <tbody>
                    <?= $rows; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td><button type="button" class="button-secondary add">Añadir regla</button></td>
                    <td><button type="button" class="button-secondary remove">Borrar reglas selecionadas</button></td>
                </tr>
                </tfoot>
            </table>
        </td>
    </tr>
</table>