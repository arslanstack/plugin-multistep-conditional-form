jQuery(document).ready(function ($) {
    function updateProgressBar(step) {
        const totalSteps = 9; // Total number of steps in your form
        const percentage = (step / totalSteps) * 100;
        $('#pbmfc-progress-bar').css('width', percentage + '%');
        $('#pbmfc-progress-bar').attr('aria-valuenow', percentage); // For accessibility
    }
    let currentStep = 1;
    updateProgressBar(currentStep);
    const totalSteps = 9; // Update total steps to 9

    $(document).on('input', '.percentage_field', function () {
        // Replace any non-numeric characters immediately upon input
        this.value = this.value.replace(/[^0-9]/g, '');

        // Enforce maximum value of 100
        if (parseInt(this.value) > 100) {
            this.value = '100';
        }
    });
    function goTop() {
        $('html, body').animate({
            scrollTop: $(".calculator-pbmfc").offset().top - 300
        }, 500);
    }
    // Function to show only the current step
    function showStep(step) {
        $('.step').hide();
        $('#step-' + step).show();
        updateProgressBar(currentStep);

    }

    // Initialize form by showing the first step
    showStep(currentStep);

    // Function to check selected services and adjust future steps
    function checkServices() {
        // Update this to only display conditional steps when they are actually the current step
        if ($('#payment_services').is(':checked') && currentStep === 3) {
            $('#step-3-payment').show();
        } else {
            $('#step-3-payment').hide();
        }

        if ($('#banking_services').is(':checked')) {
            if (currentStep === 4) {
                $('#step-4-banking').show();
            } else if (currentStep === 5) {
                $('#step-5-banking').show();
            } else {
                $('#step-4-banking, #step-5-banking').hide();
            }
        } else {
            $('#step-4-banking, #step-5-banking').hide();
        }

        if (($('#region_us').is(':checked') ||
            $('#region_eu').is(':checked') ||
            $('#region_uk').is(':checked') ||
            $('#region_apac').is(':checked') ||
            $('#region_mena').is(':checked') ||
            $('#region_latam').is(':checked')) && currentStep === 7) {
            $('#step-7-region').show();
        } else {
            $('#step-7-region').hide();
        }

        // Set default values for conditional steps
        // if (!$('#payment_services').is(':checked')) {
        //     $('input[name="payment_services_volume"]').val('0');
        //     $('input[name="payment_transactions_count"]').val('0');
        // }
        // if (!$('#banking_services').is(':checked')) {
        //     $('input[name="banking_wire_volume"]').val('0');
        //     $('input[name="banking_local_volume"]').val('0');
        //     $('input[name="banking_fx_volume"]').val('0');
        //     $('input[name="wire_transactions_count"]').val('0');
        //     $('input[name="local_transactions_count"]').val('0');
        //     $('input[name="fx_transactions_count"]').val('0');
        // }
    }

    // Function to move to the next step
    function moveNext() {
        if (currentStep === 1) {
            if ($('input[name="service_type[]"]:checked').length === 0) {
                alert('Please select at least one service type.');
                return; // Stop execution if no service is selected
            }
        } else if (currentStep === 2) {
            if ($('input[name="merchant_count"]').val() === "") {
                alert('Please enter a valid merchant count.');
                return;
            }
        }

        if (currentStep === 2) {
            if ($('#payment_services').is(':checked')) {
                currentStep = 3;
            } else if ($('#banking_services').is(':checked')) {
                currentStep = 4;
            } else {
                currentStep = 6;
            }
        } else if (currentStep === 3 && !$('#banking_services').is(':checked')) {
            currentStep = 6;
        } else if (currentStep === 5) {
            currentStep = 6;
        } else if (currentStep === 6) {
            let selectedRegions = $('input[name="regions[]"]:checked').length;

            if (selectedRegions === 0) {
                alert('Please select at least one region.');
                return; // Stop execution if no region is selected
            } else if (selectedRegions === 1) {
                // Only one region selected: Skip Step 7 and set 100%
                const selectedRegion = $('input[name="regions[]"]:checked').val();
                const percentageInput = $('input[name="' + selectedRegion.toLowerCase() + '_percentage"]');
                percentageInput.val(100);

                // Move to Step 8 directly
                currentStep = 8;
                showStep(currentStep); // Show Step 8
                goTop();

            } else {
                // Multiple regions selected: Move to Step 7
                currentStep++;
                showStep(currentStep);
                goTop();
                showOnlySelectedRegionsInStep7();
            }
        } else if (currentStep === 7) { // Validation for Step 7
            let totalPercentage = 0;
            $('input[type="number"][name$="_percentage"]').each(function () {
                totalPercentage += parseInt($(this).val()) || 0;
            });
            if (totalPercentage !== 100) {
                alert('The total percentage must equal 100%.');
                return; // Stop execution if the total percentage is not 100
            } else {
                // Move to Step 8
                currentStep++;
                showStep(currentStep);
                goTop();
            }
        } else if (currentStep === 8) {
            // Move to the Review & Submit step (Step 9)
            currentStep++;
            showStep(currentStep);
            goTop();
        } else {
            currentStep++;
        }
    }
    function showOnlySelectedRegionsInStep7() {
        const selectedRegions = $('input[name="regions[]"]:checked').map((i, el) => el.value).get();

        // Hide all percentage inputs
        $('#step-7-region .form-group').hide();

        // Show only the percentage inputs for selected regions
        selectedRegions.forEach(region => {
            // Construct the percentage input name dynamically
            const percentageInputName = region.toLowerCase() + '_percentage';
            $(`#step-7-region .form-group:has(input[name="${percentageInputName}"])`).show();
        });
    }

    // Function to move to the previous step
    function movePrev() {
        if (currentStep === 9) {
            // Move to Step 8
            currentStep--;
            showStep(currentStep);
            goTop();
        } else if (currentStep === 8) {
            // Go to Step 6 if only one region is selected
            let selectedRegions = $('input[name="regions[]"]:checked').length;
            currentStep = selectedRegions > 1 ? 7 : 6;
            showStep(currentStep);
            goTop();
        } else if (currentStep === 7) {
            // Move to Step 6
            currentStep--;
            showStep(currentStep);
            goTop();
        } else if (currentStep === 6) {
            // Determine previous step based on service type selected in Step 1
            if ($('#payment_services').is(':checked') && $('#banking_services').is(':checked')) {
                // If both services are selected, go to Step 5 
                currentStep = currentStep === 5 ? 4 : 5;
            } else if ($('#payment_services').is(':checked')) {
                currentStep = 3;
            } else if ($('#banking_services').is(':checked')) {
                currentStep = 5;
            } else {
                currentStep = 2;
            }
            showStep(currentStep);
            goTop();
        } else if (currentStep === 5) {
            // Handle Step 5 navigation based on service type
            if ($('#banking_services').is(':checked')) {
                currentStep = 4;
            } else if ($('#payment_services').is(':checked')) {
                // If only "Payment Services" is selected, go to Step 3
                currentStep = 3;
            } else {
                currentStep = 2;
            }
            showStep(currentStep);
            goTop();
        } else if (currentStep === 4) {
            // Handle Step 4 navigation
            if ($('#banking_services').is(':checked') && $('#payment_services').is(':checked')) {
                currentStep = 3;
            } else if ($('#banking_services').is(':checked')) {
                currentStep = 2;
            } else if ($('#payment_services').is(':checked')) {
                // If only "Payment Services" is selected, go to Step 3
                currentStep = 3;
            }
            showStep(currentStep);
            goTop();
        } else if (currentStep === 3 && $('#payment_services').is(':checked')) {
            currentStep = 2;
            showStep(currentStep);
        } else {
            // Default behavior: Go back to the previous step
            currentStep--;
            showStep(currentStep);
            goTop();
        }
    }
    // Function to populate the Review section
    function populateReviewSection() {
        let reviewSection = $('#review-section');
        reviewSection.empty(); // Clear any previous content

        // Get form data and display it
        const formData = $('#pbmfc-form').serializeArray();

        // Handle Service Type
        let serviceTypes = formData.filter(data => data.name === 'service_type[]').map(data => data.value);
        if (serviceTypes.length > 1) {
            serviceTypes = serviceTypes.join(' & ');
        } else {
            serviceTypes = serviceTypes[0].replace(/_/g, ' ');
        }
        reviewSection.append(`
        <div class="form-group">
            <label for="service_type[]" class="perview-label">Which services do you offer in your marketplace?</label><br>
            <span class="perview-value">
            ${serviceTypes.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}
            </span>`);

        // Handle Merchant Count
        let merchantCount = formData.find(data => data.name === 'merchant_count').value;
        reviewSection.append(`
        <div class="form-group">
            <label for="merchant_count" class="perview-label">How many merchants do you currently have in your portfolio?</label><br>
            <span class="perview-value">${merchantCount}</span>
        </div>
    `);
        const formatVolume = (value) => {
            return value !== 'N/A' && !isNaN(value) ? '$' + value.replace(/(\d{3})(?=(\d{3})+(?!\d))/g, '$1,') : 'N/A';
        };
        // Handle Payment Services Volume
        let paymentServicesVolume = formData.find(data => data.name === 'payment_services_volume').value || 'N/A';
        reviewSection.append(`
    <div class="form-group">
        <label for="payment_services_volume" class="perview-label">What is the expected total volume for Payment Services?</label><br>
        <span class="perview-value">${formatVolume(paymentServicesVolume)}</span>
    </div>
`);

        // Handle Payment Transactions Count
        let paymentTransactionsCount = formData.find(data => data.name === 'payment_transactions_count').value || 'N/A';
        reviewSection.append(`
    <div class="form-group">
        <label for="payment_transactions_count" class="perview-label">What is the expected number of payment transactions per month?</label><br>
        <span class="perview-value">${paymentTransactionsCount}</span>
    </div>
`);

        // Handle Banking Services Volumes
        let bankingWireVolume = formData.find(data => data.name === 'banking_wire_volume').value || 'N/A';
        reviewSection.append(`
    <div class="form-group">
        <label for="banking_wire_volume" class="perview-label">What is the expected total volume for Wire Services?</label><br>
        <span class="perview-value">${formatVolume(bankingWireVolume)}</span>
    </div>
`);

        let bankingLocalVolume = formData.find(data => data.name === 'banking_local_volume').value || 'N/A';
        reviewSection.append(`
    <div class="form-group">
        <label for="banking_local_volume" class="perview-label">What is the expected total volume for Local Payment Methods (ACH, SEPA)?</label><br>
        <span class="perview-value">${formatVolume(bankingLocalVolume)}</span>
    </div>
`);

        let bankingFxVolume = formData.find(data => data.name === 'banking_fx_volume').value || 'N/A';
        reviewSection.append(`
    <div class="form-group">
        <label for="banking_fx_volume" class="perview-label">What is the expected total volume for Foreign Exchange (FX) Services?</label><br>
        <span class="perview-value">${formatVolume(bankingFxVolume)}</span>
    </div>
`);

        // Handle Banking Services Transaction Counts
        let wireTransactionsCount = formData.find(data => data.name === 'wire_transactions_count').value || 'N/A';
        reviewSection.append(`
        <div class="form-group">
            <label class="perview-label" for="wire_transactions_count">What is the expected number of wire transactions per month?</label><br>
            <span class="perview-value">${wireTransactionsCount}</span>
        </div>
    `);
        let localTransactionsCount = formData.find(data => data.name === 'local_transactions_count').value || 'N/A';
        reviewSection.append(`
        <div class="form-group">
            <label class="perview-label" for="local_transactions_count">What is the expected number of local payment method transactions per month?</label><br>
            <span class="perview-value">${localTransactionsCount}</span>
        </div>
    `);
        let fxTransactionsCount = formData.find(data => data.name === 'fx_transactions_count').value || 'N/A';
        reviewSection.append(`
        <div class="form-group">
            <label class="perview-label" for="fx_transactions_count">What is the expected number of FX transactions per month?</label><br>
            <span class="perview-value">${fxTransactionsCount}</span>
        </div>
    `);

        // Handle Regions
        let regions = formData.filter(data => data.name === 'regions[]').map(data => data.value);
        if (regions.length > 1) {
            regions = regions.slice(0, -1).join(', ') + ' & ' + regions.slice(-1)[0];
        } else {
            regions = regions[0];
        }

        reviewSection.append(`
    <div class="form-group">
        <label class="perview-label" for="regions[]">Where are your users based?</label><br>
        <span class="perview-value">${regions}</span>
    </div>
`);

        // Display percentage values only for selected regions
        const selectedRegions = formData.filter(data => data.name === 'regions[]').map(data => data.value);
        selectedRegions.forEach(region => {
            let percentage = formData.find(data => data.name === `${region.toLowerCase()}_percentage`).value;
            if (percentage !== undefined) {
                reviewSection.append(`
            <div class="form-group">
                <label class="perview-label" for="${region.toLowerCase()}_percentage">${region.toUpperCase()} userbase %:</label>
                <span class="perview-value">${percentage}%</span>
            </div>
        `);
            }
        });

        // Get the personal info fields data
        let firstName = formData.find(data => data.name === 'first_name').value;
        let lastName = formData.find(data => data.name === 'last_name').value;
        let email = formData.find(data => data.name === 'email').value;
        let phone = formData.find(data => data.name === 'phone').value;
        let companyName = formData.find(data => data.name === 'company_name').value;
        let country = formData.find(data => data.name === 'country').value;
        let role = formData.find(data => data.name === 'role').value;
        let numberOfEmployees = formData.find(data => data.name === 'number_of_employees').value;

        // Display the personal info data in the Review section
        reviewSection.append(`
        <div class="form-group">
            <label class="perview-label" for="first_name">First Name:</label>
            <span class="perview-value">${firstName}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="last_name">Last Name:</label>
            <span class="perview-value">${lastName}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="email">Email:</label>
            <span class="perview-value">${email}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="phone">Phone:</label>
            <span class="perview-value">${phone}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="company_name">Company Name:</label>
            <span class="perview-value">${companyName}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="country">Country:</label>
            <span class="perview-value">${country}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="role">Role:</label>
            <span class="perview-value">${role}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="number_of_employees">Number of Employees:</label>
            <span class="perview-value">${numberOfEmployees}</span>
        </div>
        <div class="form-group">
            <label class="perview-label" for="message">Your Message:</label>
            <span class="perview-value">${formData.find(data => data.name === 'message').value}</span>
        </div>
    `);
    }
    // Next button click handler
    $('.next-btn').click(function () {
        if (validateStep(currentStep)) {
            moveNext();
            if (currentStep <= totalSteps) {
                showStep(currentStep);
                goTop();
                checkServices();
                populateReviewSection();
            }
        }
    });

    // Previous button click handler
    $('.prev-btn').click(function () {
        movePrev();
        populateReviewSection();
        if (currentStep >= 1) {
            showStep(currentStep);
            goTop();
            checkServices();
        }
    });


    // Validation function for each step
    function validateStep(step) {
        let valid = true;
        switch (step) {
            case 1:
                if ($('input[name="service_type[]"]:checked').length === 0) {
                    // Display error message next to the service type selection
                    $('#service_type_error').html('<div class="error-message">Please select at least one service type.</div>');
                    valid = false;
                } else {
                    $('#service_type_error').html('');
                }
                break;
            case 2:
                if ($('input[name="merchant_count"]').val() === "") {
                    // Display error message next to the merchant count field
                    $('#merchant_count_error').html('<div class="error-message">Please enter a valid merchant count.</div>');
                    valid = false;
                }
                // enforce minimum value to be 0 and value must be numeric
                else if ($('input[name="merchant_count"]').val() < 0 || isNaN($('input[name="merchant_count"]').val())) {
                    $('#merchant_count_error').html('<div class="error-message">Please enter a valid merchant count.</div>');
                    valid = false;
                }
                else {
                    $('#merchant_count_error').html('');
                }
                break;
            case 3:
                if ($('input[name="payment_transactions_count"]').val() < 0 || isNaN($('input[name="payment_transactions_count"]').val())) {
                    $('#payment_transactions_count_error').html('<div class="error-message">Please enter a valid payment transaction count.</div>');
                    valid = false;
                } else {
                    $('#payment_transactions_count_error').html('');
                }

                if ($('input[name="payment_services_volume"]').val() < 0 || isNaN($('input[name="payment_services_volume"]').val())) {
                    $('#payment_services_volume_error').html('<div class="error-message">Please enter a valid payment services volume.</div>');
                    valid = false;
                } else {
                    $('#payment_services_volume_error').html('');
                }

                break;
            case 4:
                // enforce minimum value to be 0 and value must be numeric for all step4 fields
                if ($('input[name="banking_wire_volume"]').val() < 0 || isNaN($('input[name="banking_wire_volume"]').val())) {
                    $('#banking_wire_volume_error').html('<div class="error-message">Please enter a valid banking wire volume.</div>');
                    valid = false;
                }
                else {
                    $('#banking_wire_volume_error').html('');
                }

                if ($('input[name="banking_local_volume"]').val() < 0 || isNaN($('input[name="banking_local_volume"]').val())) {
                    $('#banking_local_volume_error').html('<div class="error-message">Please enter a valid banking local volume.</div>');
                    valid = false;
                }
                else {
                    $('#banking_local_volume_error').html('');
                }

                if ($('input[name="banking_fx_volume"]').val() < 0 || isNaN($('input[name="banking_fx_volume"]').val())) {
                    $('#banking_fx_volume_error').html('<div class="error-message">Please enter a valid banking fx volume.</div>');
                    valid = false;
                }
                else {
                    $('#banking_fx_volume_error').html('');
                }
                break;
            case 5:
                // enforce minimum value to be 0 and value must be numeric for all step5 fields
                if ($('input[name="wire_transactions_count"]').val() < 0 || isNaN($('input[name="wire_transactions_count"]').val())) {
                    $('#wire_transactions_count_error').html('<div class="error-message">Please enter a valid wire transactions count.</div>');
                    valid = false;
                }
                else {
                    $('#wire_transactions_count_error').html('');
                }

                if ($('input[name="local_transactions_count"]').val() < 0 || isNaN($('input[name="local_transactions_count"]').val())) {
                    $('#local_transactions_count_error').html('<div class="error-message">Please enter a valid local transactions count.</div>');
                    valid = false;
                }
                else {
                    $('#local_transactions_count_error').html('');
                }

                if ($('input[name="fx_transactions_count"]').val() < 0 || isNaN($('input[name="fx_transactions_count"]').val())) {
                    $('#fx_transactions_count_error').html('<div class="error-message">Please enter a valid fx transactions count.</div>');
                    valid = false;
                }
                else {
                    $('#fx_transactions_count_error').html('');
                }
                break;
            case 6:
                if ($('input[name="regions[]"]:checked').length === 0) {
                    // Display error message next to the regions selection
                    $('#region_error').html('<div class="error-message">Please select at least one region.</div>');
                    valid = false;
                } else {
                    $('#region_error').html('');
                }
                break;
            case 7:

                let total = 0;
                $('input[type="number"][name$="_percentage"]').each(function () {
                    total += parseInt($(this).val()) || 0;
                });
                if (total !== 100) {
                    // Display error message next to the percentage fields
                    $('#percentage_fields_error').html('<div class="error-message">The total percentage must equal 100%.</div>');
                    valid = false;
                } else {
                    $('#percentage_fields_error').html('');
                }
                break;
            case 8: // Validation for Step 8
                if ($('input[name="first_name"]').val() === "") {
                    // Display error message next to the First Name field
                    $('#first_name_error').html('<div class="error-message">Please enter your first name.</div>');
                    valid = false;
                } else {
                    $('#first_name_error').html('');
                }
                if ($('input[name="last_name"]').val() === "") {
                    // Display error message next to the Last Name field
                    $('#last_name_error').html('<div class="error-message">Please enter your last name.</div>');
                    valid = false;
                } else {
                    $('#last_name_error').html('');
                }
                if ($('input[name="email"]').val() === "") {
                    // Display error message next to the Email field
                    $('#email_error').html('<div class="error-message">Please enter your email address.</div>');
                    valid = false;
                }
                // } if email not valid then also show error
                else if (!validateEmail($('input[name="email"]').val())) {
                    $('#email_error').html('<div class="error-message">Please enter a valid email address.</div>');
                    $('input[name="email"]').focus();
                    valid = false;
                }
                else {
                    $('#email_error').html('');
                }
                if ($('input[name="phone"]').val() === "") {
                    // Display error message next to the Phone field
                    $('#phone_error').html('<div class="error-message">Please enter your phone number.</div>');
                    valid = false;
                } else {
                    $('#phone_error').html('');
                }
                if ($('input[name="company_name"]').val() === "") {
                    // Display error message next to the Company Name field
                    $('#company_name_error').html('<div class="error-message">Please enter your company name.</div>');
                    valid = false;
                } else {
                    $('#company_name_error').html('');
                }
                if ($('input[name="country"]').val() === "") {
                    // Display error message next to the Country field
                    $('#country_error').html('<div class="error-message">Please enter your country.</div>');
                    valid = false;
                } else {
                    $('#country_error').html('');
                }
                if ($('select[name="role"]').val() === "") {
                    // Display error message next to the Role field
                    $('#role_error').html('<div class="error-message">Please select your role.</div>');
                    valid = false;
                } else {
                    $('#role_error').html('');
                }
                if ($('select[name="number_of_employees"]').val() === "") {
                    $('#number_of_employees_error').html('<div class="error-message">Please select No of employees in your company.</div>');
                    valid = false;
                } else {
                    $('#number_of_employees_error').html('');
                }
                // for message
                if ($('textarea[name="message"]').val() === "") {
                    $('#message_error').html('<div class="error-message">Please enter your message.</div>');
                    valid = false;
                } else {
                    $('#message_error').html('');
                }
                // for terms and conditions
                if (!$('input[name="privacy_policy"]').is(':checked')) {
                    $('#privacy_policy_error').html('<div class="error-message">Please accept the Privacy policy and terms & conditions.</div>');
                    valid = false;
                } else {
                    $('#privacy_policy_error').html('');
                }
                break;
            default:
                break;
        }
        return valid;
    }


    // Form submission handler
    $('#pbmfc-form').on('submit', function (e) {
        e.preventDefault();
        // submit button text change to Generating ...
        $('.submit-btn').html('Submiting');
        //disable submit and previous button
        $('.submit-btn').prop('disabled', true);
        $('.prev-btn').prop('disabled', true);
        const formData = $(this).serializeArray();

        $.ajax({
            url: pbmfc_vars.ajax_url,  // Use wp_localize_script's output for ajax_url
            type: 'POST',
            data: {
                action: 'pbmfc_submit_form',  // This action is the PHP function that handles the request
                form_data: formData
            },
            success: function (response) {
                if (response.success) {
                    console.log(response.data.message); // Log success message
                    // alert('Form submitted successfully!');
                    // enable submit and previous button
                    $('.submit-btn').html('Submit');
                    $('.submit-btn').prop('disabled', false);
                    $('.prev-btn').prop('disabled', false);
                    // Reset the form and take to first page
                    currentStep = 1;
                    showStep(currentStep);
                    goTop();
                    // show success-alert
                    $('#success-alert').show();
                    $('#pbmfc-form').trigger('reset');
                    checkServices();
                    populateReviewSection();

                } else {
                    alert('Form submission failed.');
                    $('.submit-btn').html('Submit');
                    $('.submit-btn').prop('disabled', false);
                    $('.prev-btn').prop('disabled', false);
                }
            },
            error: function (error) {
                console.error(error);
                alert('An error occurred. Please try again.');
                $('.submit-btn').html('Submit');
                $('.submit-btn').prop('disabled', false);
                $('.prev-btn').prop('disabled', false);
            }
        });
    });
    // Plugin created by Muhammad Arslan | arslanstack@gmail.com
    // Trigger checkServices initially for conditional steps
    checkServices();


    // call perview section when moving to step 8
    $(document).on('click', '.next-btn', function () {
        $('input[name="regions[]"]').change(function () {
            // Reset percentage values when regions are changed
            $('input[type="number"][name$="_percentage"]').val(''); // Clear percentage fields

            // ... (Rest of the change event handler remains the same)
        });
        populateReviewSection();
    });

    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

});