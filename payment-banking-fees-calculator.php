<?php

/**
 * Plugin Name: Marketplace Revenue Calculator
 * Description: A custom plugin to calculate marketplace fees for payment and banking services.
 * Version: 2.5
 * Author: Explore Logics IT Solutions
 * Author URI: https://www.explorelogics.com
 */
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
// Marketplace Revenue Calculator v2.5.zip
// Register shortcode to display the form
function pbmfc_display_form()
{
    ob_start();
?>
    <div class="calculator-pbmfc">
        <div class="progress-pbmfc">
            <div class="progress-bar-pbmfc" id="pbmfc-progress-bar" role="progressbar" style="width:0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <form id="pbmfc-form" class="pbmfc-form">
            <!-- Step 1: Select Your Service Type -->
            <div id="step-1" class="step">

                <h4 class="page-form-title"> Select Your Service Type</h4>
                <div class="form-group">
                    <label class="marketplace_label page-form-question pb-3">Which services do you want to offer in your marketplace?</label><br>
                    <input type="checkbox" name="service_type[]" value="payment_services" class="marketplace_input" onchange="if(this.checked){ document.getElementById('payment_services_options').style.display = 'block'; } else { document.getElementById('payment_services_options').style.display = 'none';}" id="payment_services"> <label for="payment_services" class="marketplace_input_label">Payment Services</label><br>
                    <div class="form-group" id="payment_services_options" style="display: none;">
                        <label class="page-form-question-services-options">Which Payment Services are you interested in?</label> <br>
                        <input type="checkbox" name="payment_services_options[]" value="ACH" class="marketplace_input" id="ach"> <label for="ach" class="marketplace_input_label">ACH</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="APMs" class="marketplace_input" id="apm"> <label for="apm" class="marketplace_input_label">APMs</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Card Acquiring" class="marketplace_input" id="card_acquiring"> <label for="card_acquiring" class="marketplace_input_label">Card Acquiring</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Clearing Service" class="marketplace_input" id="clearing_service"> <label for="clearing_service" class="marketplace_input_label">Clearing Service</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Crossborder FX" class="marketplace_input" id="crossborder_fx"> <label for="crossborder_fx" class="marketplace_input_label">Crossborder FX</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Local Payment Methods" class="marketplace_input" id="local_payment_methods"> <label for="local_payment_methods" class="marketplace_input_label">Local Payment Methods</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="On and Off Ramps" class="marketplace_input" id="on_and_off_ramps"> <label for="on_and_off_ramps" class="marketplace_input_label">On and Off Ramps</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Open Banking" class="marketplace_input" id="open_banking"> <label for="open_banking" class="marketplace_input_label">Open Banking</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Payfacs" class="marketplace_input" id="payfacs"> <label for="payfacs" class="marketplace_input_label">Payfacs</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Real-Time Payments" class="marketplace_input" id="real_time_payments"> <label for="real_time_payments" class="marketplace_input_label">Real-Time Payments</label><br>
                        <input type="checkbox" name="payment_services_options[]" value="Wire Transfers" class="marketplace_input" id="wire_transfers"> <label for="wire_transfers" class="marketplace_input_label">Wire Transfers</label><br>
                        <div id="payment_services_options_error"></div><br>
                    </div>
                    <input type="checkbox" name="service_type[]" value="banking_services" class="marketplace_input" onchange="if(this.checked){ document.getElementById('banking_services_options').style.display = 'block'; } else { document.getElementById('banking_services_options').style.display = 'none';}" id="banking_services"> <label for="banking_services" class="marketplace_input_label">Banking Services</label><br>
                    <div class="form-group" id="banking_services_options" style="display: none;">
                        <label class="page-form-question-services-options">Which Banking Services are you interested in?</label> <br>
                        <input type="checkbox" name="banking_services_options[]" value="Banking as a Service" class="marketplace_input" id="banking_as_a_service"> <label for="banking_as_a_service" class="marketplace_input_label">Banking as a Service</label><br>
                        <input type="checkbox" name="banking_services_options[]" value="Client Money Accounts" class="marketplace_input" id="client_money_accounts"> <label for="client_money_accounts" class="marketplace_input_label">Client Money Accounts</label><br>
                        <input type="checkbox" name="banking_services_options[]" value="FBO Accounts" class="marketplace_input" id="fbo_accounts"> <label for="fbo_accounts" class="marketplace_input_label">FBO Accounts</label><br>
                        <input type="checkbox" name="banking_services_options[]" value="Multi Currency Accounts" class="marketplace_input" id="multi_currency_accounts"> <label for="multi_currency_accounts" class="marketplace_input_label">Multi Currency Accounts</label><br>
                        <input type="checkbox" name="banking_services_options[]" value="Operating Accounts" class="marketplace_input" id="operating_accounts"> <label for="operating_accounts" class="marketplace_input_label">Operating Accounts</label><br>
                        <input type="checkbox" name="banking_services_options[]" value="Segregated Accounts" class="marketplace_input" id="segregated_accounts"> <label for="segregated_accounts" class="marketplace_input_label">Segregated Accounts</label><br>
                        <input type="checkbox" name="banking_services_options[]" value="Sponsor Banks" class="marketplace_input" id="sponsor_banks"> <label for="sponsor_banks" class="marketplace_input_label">Sponsor Banks</label><br>
                        <input type="checkbox" name="banking_services_options[]" value="Virtual IBANs" class="marketplace_input" id="virtual_ibans"> <label for="virtual_ibans" class="marketplace_input_label">Virtual IBANs</label><br>
                        <!-- <input type="text" class="form-control page-form-input" name="merchant_count" placeholder="e.g., 500" required> -->
                        <div id="banking_services_options_error"></div>
                    </div><br>
                    <div id="service_type_error"></div>
                </div>
                <button type="button" class="btn btn-primary next-btn">Next</button>
                <!-- bootstrap success alert -->
                <div class="alert alert-success" role="alert" id="success-alert" style="display:none;">
                    <span>Thank you for submission. It has been sent.</span>
                </div>
            </div>
            <!-- Step 10: Services Interest -->
            <div id="step-10" class="step" style="display: none;">
                <h4 class="page-form-title"></h4>


                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>
            <!-- Step 2: Portfolio Details -->
            <div id="step-2" class="step" style="display: none;">
                <h4 class="page-form-title">Portfolio Details</h4>
                <div class="form-group">
                    <label class="page-form-question">How many merchants do you currently have in your portfolio?</label>
                    <input type="text" class="form-control page-form-input" name="merchant_count" placeholder="e.g., 500" required>
                    <div id="merchant_count_error"></div>
                </div>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>

            <!-- Step 3: Payment Services Volume (conditional) -->
            <div id="step-3-payment" class="step" style="display:none;">
                <h4 class="page-form-title"> Payment Services Volume</h4>
                <div class="form-group">
                    <label class="page-form-question">What is the expected total volume for Payment Services?</label>
                    <input type="text" class="form-control page-form-input" name="payment_services_volume" placeholder="e.g., $1,000,000" title="Please enter a valid currency amount.">
                    <div id="payment_services_volume_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">What is the expected number of payment transactions per month?</label>
                    <input type="text" class="form-control page-form-input" name="payment_transactions_count" placeholder="e.g., 10,000">
                    <div id="payment_transactions_count_error"></div>
                </div>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>

            <!-- Step 4: Banking Services Volume (conditional) -->
            <div id="step-4-banking" class="step" style="display:none;">
                <h4 class="page-form-title"> Banking Services Volume</h4>
                <div class="form-group">
                    <label class="page-form-question">What is the expected total volume for Wire Services?</label>
                    <input type="text" class="form-control page-form-input" name="banking_wire_volume" placeholder="e.g., $500,000">
                    <div id="banking_wire_volume_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">What is the expected total volume for Local Payment Methods (ACH, SEPA)?</label>
                    <input type="text" class="form-control page-form-input" name="banking_local_volume" placeholder="e.g., $300,000">
                    <div id="banking_local_volume_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">What is the expected total volume for Foreign Exchange (FX) Services?</label>
                    <input type="text" class="form-control page-form-input" name="banking_fx_volume" placeholder="e.g., $200,000">
                    <div id="banking_fx_volume_error"></div>
                </div>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>

            <!-- Step 5: Transaction Details (Banking Services) -->
            <div id="step-5-banking" class="step" style="display:none;">
                <h4 class="page-form-title"> Transaction Details</h4>
                <div class="form-group">
                    <label class="page-form-question">What is the expected number of wire transactions per month?</label>
                    <input type="text" class="form-control page-form-input" name="wire_transactions_count" placeholder="e.g., 1,000">
                    <div id="wire_transactions_count_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">What is the expected number of local payment method transactions per month?</label>
                    <input type="text" class="form-control page-form-input" name="local_transactions_count" placeholder="e.g., 5,000">
                    <div id="local_transactions_count_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">What is the expected number of FX transactions per month?</label>
                    <input type="text" class="form-control page-form-input" name="fx_transactions_count" placeholder="e.g., 2,000">
                    <div id="fx_transactions_count_error"></div>
                </div>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>

            <!-- Step 6: Geographic Distribution -->
            <div id="step-6" class="step" style="display:none;">
                <h4 class="page-form-title"> Geographic Distribution</h4>
                <div class="form-group">
                    <label class="page-form-question pb-2">Where are your users based?</label><br>
                    <input type="checkbox" name="regions[]" value="US" id="region_us"> <label for="region_us" class="region_label"> United States (US)</label><br>
                    <input type="checkbox" name="regions[]" value="EU" id="region_eu"> <label for="region_eu" class="region_label">European Union (EU)</label><br>
                    <input type="checkbox" name="regions[]" value="UK" id="region_uk"> <label for="region_uk" class="region_label">United Kingdom (UK)</label><br>
                    <input type="checkbox" name="regions[]" value="APAC" id="region_apac"> <label for="region_apac" class="region_label">Asia-Pacific (APAC)</label><br>
                    <input type="checkbox" name="regions[]" value="MENA" id="region_mena"> <label for="region_mena" class="region_label">Middle East and North Africa (MENA)</label><br>
                    <input type="checkbox" name="regions[]" value="LATAM" id="region_latam"> <label for="region_latam" class="region_label">Latin America (LATAM)</label><br>
                    <div id="region_error"></div>
                </div>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>

            <!-- Step 7: User Distribution by Region (conditional) -->
            <div id="step-7-region" class="step" style="display:none;">
                <h4 class="page-form-title"> User Distribution by Region</h4>
                <div class="form-group">
                    <label class="page-form-question">United States (US)</label>
                    <input type="number" class="form-control percentage_field  page-form-input" name="us_percentage" placeholder="e.g., 40%">
                    <div id="us_percentage_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">European Union (EU)</label>
                    <input type="number" class="form-control percentage_field  page-form-input" name="eu_percentage" placeholder="e.g., 30%">
                    <div id="eu_percentage_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">United Kingdom (UK)</label>
                    <input type="number" class="form-control percentage_field  page-form-input" name="uk_percentage" placeholder="e.g., 30%">
                    <div id="uk_percentage_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">Asia-Pacific (APAC)</label>
                    <input type="number" class="form-control percentage_field  page-form-input" name="apac_percentage" placeholder="e.g., 0%">
                    <div id="apac_percentage_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">Middle East and North Africa (MENA)</label>
                    <input type="number" class="form-control percentage_field  page-form-input" name="mena_percentage" placeholder="e.g., 0%">
                    <div id="mena_percentage_error"></div>
                </div>
                <div class="form-group">
                    <label class="page-form-question">Latin America (LATAM)</label>
                    <input type="number" class="form-control percentage_field  page-form-input" name="latam_percentage" placeholder="e.g., 0%">
                    <div id="latam_percentage_error"></div>
                </div>
                <div id="percentage_fields_error"></div>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>

            <!-- Step 8: Your Information -->
            <div id="step-8" class="step" style="display:none;">
                <h4 class="page-form-title"> Your Information</h4>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <!-- <label for="first_name">First Name: <sup class="text-danger">*</sup></label> -->
                        <input type="text" class="form-control page-form-input" name="first_name" placeholder="First Name*" required>
                        <div id="first_name_error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <!-- <label for="last_name">Last Name: <sup class="text-danger">*</sup></label> -->
                        <input type="text" class="form-control page-form-input" name="last_name" placeholder="Last Name*" required>
                        <div id="last_name_error"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <!-- <label for="email">Email: <sup class="text-danger">*</sup></label> -->
                        <input type="email" class="form-control page-form-input" name="email" placeholder="Email*" required>
                        <div id="email_error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <!-- <label for="phone">Phone: <sup class="text-danger">*</sup></label> -->
                        <input type="tel" class="form-control page-form-input" name="phone" placeholder="Phone*" required>
                        <div id="phone_error"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <!-- <label for="company_name">Company Name: <sup class="text-danger">*</sup></label> -->
                        <input type="text" class="form-control page-form-input" name="company_name" placeholder="Company Name*" required>
                        <div id="company_name_error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <!-- <label for="country">Country: <sup class="text-danger">*</sup></label> -->
                        <input type="text" class="form-control page-form-input" name="country" placeholder="Country*" required>
                        <div id="country_error"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <!-- <label for="role">Role: <sup class="text-danger">*</sup></label> -->
                        <select class="form-control page-form-input dropdowns-custom" name="role" required>
                            <option value="">Role*</option>
                            <option value="CEO">CEO</option>
                            <option value="CTO">CTO</option>
                            <option value="CCO">CCO</option>
                            <option value="COO">COO</option>
                            <option value="Other">Other</option>
                        </select>
                        <div id="role_error"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <!-- <label for="number_of_employees">Number of Employees</label> -->
                        <select class="form-control page-form-input dropdowns-custom" required name="number_of_employees">
                            <option value="">Number of Employees</option>
                            <option value="<10">
                                < 10</option>
                            <option value="11-50">11-50</option>
                            <option value="51-100">51-100</option>
                            <option value="100+">100+</option>
                        </select>
                        <div id="number_of_employees_error"></div>
                    </div>
                </div>
                <div class="form-group">
                    <!-- <label for="message">Your Message:</label> -->
                    <textarea class="form-control" name="message" required placeholder="Please tell us more about your needs."></textarea>
                    <div id="message_error"></div>
                </div>
                <div class="form-group">
                    <label for="privacy" class="privacy"><input type="checkbox" name="privacy_policy" id="privacy" value="1" required> I confirm that I have read the <a href="https://ahrvo.com/data-privacy-policy/" target="_blank" class="terms-link">Privacy Policy</a> and <a href="https://ahrvo.com/terms-of-service/" target="_blank" class="terms-link">Terms & Conditions</a>.</label>
                    <div id="privacy_policy_error"></div>
                </div>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="button" class="btn btn-primary next-btn">Next</button>
            </div>

            <!-- Step 9: Review & Submit -->
            <div id="step-9" class="step" style="display:none;">
                <h4 class="page-form-title">Review & Submit</h4>
                <div id="review-section">
                    <!-- Review section will be dynamically populated -->
                </div>
                <p class="submit-instructions">Submit your responses to generate your personalized Payment and
                    Banking Marketplace Fees Report.</p>
                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                <button type="submit" class="btn btn-success submit-btn">Submit</button>
            </div>
        </form>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('pbmfc_form', 'pbmfc_display_form');

// Enqueue necessary scripts and styles
function pbmfc_enqueue_scripts()
{
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('pbmfc-script', plugins_url('/js/form.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_style(
        'pbmfc-style', // Unique ID for your stylesheet
        plugins_url('/css/form.css', __FILE__), // Full path to your stylesheet
        array('bootstrap-css'), // Array of dependencies (Bootstrap)
        filemtime(plugin_dir_path(__FILE__) . 'css/form.css') // Optional: Use filemtime for cache busting 
    );
    // Localize script to pass ajax_url to JavaScript
    wp_localize_script('pbmfc-script', 'pbmfc_vars', array(
        'ajax_url' => admin_url('admin-ajax.php')  // Pass the AJAX URL to JavaScript
    ));
}
add_action('wp_enqueue_scripts', 'pbmfc_enqueue_scripts');

// Handle AJAX form submission
function pbmfc_submit_form()
{
    if (isset($_POST['form_data'])) {
        $form_data = $_POST['form_data'];

        // Extract the user's email and name from the form data
        $user_email = '';
        $first_name = '';
        $last_name = '';
        $merchant_count = '';
        $payment_transactions_count = '';
        $payment_services_volume = '';
        $banking_wire_volume = '';
        $banking_local_volume = '';
        $banking_fx_volume = '';
        $wire_transactions_count = '';
        $local_transactions_count = '';
        $fx_transactions_count = '';
        $regions = [];
        $us_percentage = '';
        $eu_percentage = '';
        $uk_percentage = '';
        $apac_percentage = '';
        $mena_percentage = '';
        $latam_percentage = '';
        $role = '';
        $company_name = '';
        $message_content = '';
        foreach ($form_data as $field) {
            switch ($field['name']) {
                case 'email':
                    $user_email = sanitize_email($field['value']);
                    break;
                case 'first_name':
                    $first_name = sanitize_text_field($field['value']);
                    break;
                case 'last_name':
                    $last_name = sanitize_text_field($field['value']);
                    break;
                case 'merchant_count':
                    $merchant_count = sanitize_text_field($field['value']);
                    break;
                case 'payment_transactions_count':
                    $payment_transactions_count = sanitize_text_field($field['value']);
                    break;
                case 'payment_services_volume':
                    $payment_services_volume = sanitize_text_field($field['value']);
                    break;
                case 'banking_wire_volume':
                    $banking_wire_volume = sanitize_text_field($field['value']);
                    break;
                case 'banking_local_volume':
                    $banking_local_volume = sanitize_text_field($field['value']);
                    break;
                case 'banking_fx_volume':
                    $banking_fx_volume = sanitize_text_field($field['value']);
                    break;
                case 'wire_transactions_count':
                    $wire_transactions_count = sanitize_text_field($field['value']);
                    break;
                case 'local_transactions_count':
                    $local_transactions_count = sanitize_text_field($field['value']);
                    break;
                case 'fx_transactions_count':
                    $fx_transactions_count = sanitize_text_field($field['value']);
                    break;
                case 'regions[]':
                    $regions[] = sanitize_text_field($field['value']);
                    break;
                case 'us_percentage':
                    $us_percentage = sanitize_text_field($field['value']);
                    break;
                case 'eu_percentage':
                    $eu_percentage = sanitize_text_field($field['value']);
                    break;
                case 'uk_percentage':
                    $uk_percentage = sanitize_text_field($field['value']);
                    break;
                case 'apac_percentage':
                    $apac_percentage = sanitize_text_field($field['value']);
                    break;
                case 'mena_percentage':
                    $mena_percentage = sanitize_text_field($field['value']);
                    break;
                case 'latam_percentage':
                    $latam_percentage = sanitize_text_field($field['value']);
                    break;
                case 'role':
                    $role = sanitize_text_field($field['value']);
                    break;
                case 'number_of_employees':
                    $number_of_employees = sanitize_text_field($field['value']);
                    break;
                case 'company_name':
                    $company_name = sanitize_text_field($field['value']);
                    break;
                case 'phone':
                    $phone = sanitize_textarea_field($field['value']);
                    break;
                case 'country':
                    $country = sanitize_textarea_field($field['value']);
                    break;
                case 'message':
                    $message_content = sanitize_textarea_field($field['value']);
                    break;
            }
        }
        // Format service types
        $service_types = [];
        foreach ($form_data as $field) {
            if ($field['name'] === 'service_type[]') {
                $service_types[] = ucfirst(str_replace('_', ' ', $field['value']));
            }
        }

        $service_types_text = implode(' & ', $service_types);
        $payment_services = [];
        foreach ($form_data as $field) {
            if ($field['name'] === 'payment_services_options[]') {
                $payment_services[] = $field['value'];
            }
        }
        $payment_services_options = '<ul style="padding-left: 0px !important;">';
        foreach ($payment_services as $servicer) {
            $payment_services_options .= '<li>' . $servicer . '</li>';
        }
        $payment_services_options .= '</ul>';

        $banking_services = [];
        foreach ($form_data as $field) {
            if ($field['name'] === 'banking_services_options[]') {
                $banking_services[] = $field['value'];
            }
        }
        $banking_services_options = '<ul style="padding-left: 0px !important;">';
        foreach ($banking_services as $servicer) {
            $banking_services_options .= '<li>' . $servicer . '</li>';
        }
        $banking_services_options .= '</ul>';

        // Function to format field names
        function format_field_name($field_name)
        {
            $formatted_name = str_replace('_', ' ', $field_name);
            return ucwords($formatted_name);
        }

        // Format regions and percentages
        $regions = [
            'US' => 'us_percentage',
            'EU' => 'eu_percentage',
            'UK' => 'uk_percentage',
            'APAC' => 'apac_percentage',
            'MENA' => 'mena_percentage',
            'LATAM' => 'latam_percentage'
        ];
        $region_output = '<h3>User Base Regions</h3>';
        foreach ($regions as $region => $percentage_field) {
            $region_selected = false;
            foreach ($form_data as $field) {
                if ($field['name'] === 'regions[]' && $field['value'] === $region) {
                    $region_selected = true;
                }
                if ($field['name'] === $percentage_field && $region_selected && !empty($field['value'])) {
                    $region_output .= '<p>' . $region . ': ' . $field['value'] . '%</p>';
                }
            }
        }

        // Email settings
        // $admin_email = get_option('admin_email');
        $admin_email = "yaseen3327095758@gmail.com";
        // $admin_email = "getintouch@kycaml.tech";
        $subject = 'Ahrvo Network Marketplace Revenue Report is Ready – Let’s Discuss Next Steps';

        // Prepare the email message for both user and admin
        $message = '<p><strong style="font-size:18px;">Hi ' . $first_name . ' ' . $last_name . ',</strong></p>';
        $message .= '<p>Thank you for completing our <strong>Ahrvo Network Marketplace Revenue</strong> questionnaire.';
        $message .= '<h3>Your Marketplace Revenue Report Submission</h3>';
        // Include formatted service types
        $message .= '<p><strong>Which services do you offer in your marketplace?</strong></p>';
        $message .= $service_types_text;
        if (in_array('Payment services', $service_types)) {
            $message .= '<p><strong>Which Payment Services do you offer in your marketplace?</strong></p>';
            $message .= $payment_services_options;
        }
        if (in_array('Banking services', $service_types)) {
            $message .= '<p><strong>Which Banking Services do you offer in your marketplace?</strong></p>';
            $message .= $banking_services_options;
        }
        $message .= '<p><strong>How many merchants do you currently have in your portfolio?</strong></p>';
        $message .= (!empty($merchant_count) ? $merchant_count : 'N/A');
        $message .= '<p><strong>What is the expected number of payment transactions per month?</strong></p>';
        $message .= (!empty($payment_transactions_count) ? $payment_transactions_count : 'N/A');
        $message .= '<p><strong>What is the expected total volume for Payment Services?</strong> </p>';
        $message .= (!empty($payment_services_volume) ? $payment_services_volume : 'N/A');
        $message .= '<p><strong>What is the expected total volume for Wire Services?</strong></p>';
        $message .= (!empty($banking_wire_volume) ? $banking_wire_volume : 'N/A');
        $message .= '<p><strong>What is the expected total volume for Local Payment Methods (ACH, SEPA)?</strong></p>';
        $message .= (!empty($banking_local_volume) ? $banking_local_volume : 'N/A');
        $message .= '<p><strong>What is the expected total volume for Foreign Exchange (FX) Services?</strong></p>';
        $message .= (!empty($banking_fx_volume) ? $banking_fx_volume : 'N/A');
        $message .= '<p><strong>What is the expected number of wire transactions per month?</strong></p>';
        $message .= (!empty($wire_transactions_count) ? $wire_transactions_count : 'N/A');
        $message .= '<p><strong>What is the expected number of local payment method transactions per month?</strong></p>';
        $message .= (!empty($local_transactions_count) ? $local_transactions_count : 'N/A');
        $message .= '<p><strong>What is the expected number of FX transactions per month?</strong></p>';
        $message .= (!empty($fx_transactions_count) ? $fx_transactions_count : 'N/A');

        // User Base Region Distribution
        $region_output = '<h3>Where are your users based?</h3>';

        if (!empty($us_percentage)) {
            $region_output .= '<p><strong>United States (US):</strong> ' . $us_percentage . '%</p>';
        }
        if (!empty($eu_percentage)) {
            $region_output .= '<p><strong>European Union (EU):</strong> ' . $eu_percentage . '%</p>';
        }
        if (!empty($uk_percentage)) {
            $region_output .= '<p><strong>United Kingdom (UK):</strong> ' . $uk_percentage . '%</p>';
        }
        if (!empty($apac_percentage)) {
            $region_output .= '<p><strong>Asia Pacific (APAC):</strong> ' . $apac_percentage . '%</p>';
        }
        if (!empty($mena_percentage)) {
            $region_output .= '<p><strong>Middle East and North Africa (MENA):</strong> ' . $mena_percentage . '%</p>';
        }
        if (!empty($latam_percentage)) {
            $region_output .= '<p><strong>Latin America (LATAM):</strong> ' . $latam_percentage . '%</p>';
        }

        // Add this output to the message
        $message .= $region_output;
        $message .= '<p><strong>Email:</strong> ' . $user_email . '</p>';
        $message .= '<p><strong>Phone:</strong> ' . $phone . '</p>';
        $message .= '<p><strong>Country:</strong> ' . $country . '</p>';
        $message .= '<p><strong>Company Name:</strong> ' . $company_name . '</p>';
        $message .= '<p><strong>Role:</strong> ' . $role . '</p>';
        $message .= '<p><strong>No of Employees:</strong> ' . $number_of_employees . '</p>';
        $message .= '<p><strong>Message:</strong> ' . $message_content . '</p>';
        $message .= '<p><strong>Submitted on:</strong> ' . date('F j, Y, g:i a') . '</p>';
        // Set email headers
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Send the email to the admin
        wp_mail($admin_email, $subject, $message, $headers);
        wp_mail($user_email, $subject, $message, $headers);

        // Send a success response back to the form
        wp_send_json_success(array('message' => 'Form submitted successfully!'));
    } else {
        // Send an error response if form data is not received
        wp_send_json_error(array('message' => 'Form submission failed. No data received.'));
    }
}

// Register AJAX actions for logged-in and non-logged-in users
add_action('wp_ajax_pbmfc_submit_form', 'pbmfc_submit_form');
add_action('wp_ajax_nopriv_pbmfc_submit_form', 'pbmfc_submit_form');
