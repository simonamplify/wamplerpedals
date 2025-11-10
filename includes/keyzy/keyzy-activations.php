<?php
// Include Keyzy API functions
require_once get_stylesheet_directory() . '/includes/keyzy/keyzy-api.php';

// Function to display activations for a given product serial
function keyzy_display_activations($serial, $api_key, $app_id, $max_host_count) {

    // Validate inputs
    if (!$serial || !$api_key || !$app_id) {
        echo "<p>Missing serial, API key, or app ID.</p>";
        return;
    }

    // Fetch activations from Keyzy API
    $data = keyzy_get_activations($serial, $app_id, $api_key);

    // Handle errors
    if (is_wp_error($data)) {
        echo "<p>Error fetching activations for serial $serial</p>";
        return;
    }

    // Display activations
    if (!empty($data['data']) && is_array($data['data'])) {

        // Count activations
        $activation_count = 0;
        foreach ($data['data'] as $activation) {
            if ($activation['activated'] == 1 ) {
                $activation_count++;
            }
        }
        $activation_state = 'No Activation data found.';
        if ($activation_count === 0) {
            $activation_state = '<span class="count zero">0</span> Activations (';
        } elseif ($activation_count === 1) {
            $activation_state = '<span class="count">' . $activation_count . '</span> Activation (';    
        } else {
            $activation_state = '<span class="count">' . $activation_count . '</span> Activations (';
        }
        
        // Display activation state
        echo '<div class="activation-state">' . $activation_state . esc_html($max_host_count) . ')</div>';

        foreach ($data['data'] as $activation) {
            // Skip non-activated entries
            if ($activation['activated'] != 1 ) {
                continue; 
            }
            // Format date
            $date_raw = $activation['created_at'] ?? '';
            $date_formatted = '';
            if ($date_raw) {
                try {
                    $dt = new DateTime($date_raw);
                    $date_formatted = $dt->format('d/m/Y');
                } catch (Exception $e) {
                    $date_formatted = esc_html($date_raw);
                }
            } ?>
            <details name="activations" aria-label="Activation details for <?php echo esc_html(!empty($activation['device_tag']) ? $activation['device_tag'] : 'Unknown Device'); ?>">
                <summary>
                    <strong><?php echo esc_html(!empty($activation['device_tag']) ? $activation['device_tag'] : 'Unknown Device'); ?></strong>
                    <?php echo $date_formatted ? ' <small>(on: ' . esc_html($date_formatted) . ')</small>' : ''; ?>
                </summary>
                <div class="content">
                    <small class="license-version">Version: <strong><?php echo esc_html(!empty($activation['product_name']) ? $activation['product_name'] : 'Unknown'); ?></strong></small>
                    <small class="host-id">Host ID: <strong><?php echo esc_html(!empty($activation['host_id']) ? $activation['host_id'] : 'Unknown'); ?></strong></small>
                    <div class="btns-wrapper">
                        <button class="deactivate-license-btn button drkBtn" data-activation-id="<?php echo esc_attr($activation['id']); ?>">
                            Deactivate License
                        </button>
                        <button class="confirm-deactivate-btn button orangeBtn" data-activation-id="<?php echo esc_attr($activation['id']); ?>" style="display:none;">Confirm Deactivation</button>
                    </div>
                </div>
            </details>
        <?php }

    } else {
        echo '<div class="activation-state"><span class="count">0</span> Activations</div>';
    } ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle deactivate and confirm buttons
        // Select all deactivate-license-btn button wrappers
        document.querySelectorAll('.btns-wrapper').forEach(function(wrapper) {
            // Select the deactivate and confirm buttons
            const deactivateBtn = wrapper.querySelector('.deactivate-license-btn');
            const confirmBtn = wrapper.querySelector('.confirm-deactivate-btn');
            // Set up confimred state
            let confirmed = false;
            // Deactivate button click handler
            deactivateBtn.addEventListener('click', function() {
                if (confirmed) return;
                deactivateBtn.style.display = 'none';
                confirmBtn.style.display = 'inline';
                setTimeout(function() {
                    if (!confirmed) {
                        deactivateBtn.style.display = 'inline';
                        confirmBtn.style.display = 'none';
                    }
                }, 7000);
            });
            // Confirm button click handler
            confirmBtn.addEventListener('click', function() {
                confirmed = true;
                confirmBtn.textContent = 'Deactivating...';
                var activationId = confirmBtn.getAttribute('data-activation-id');
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'action=keyzy_delete_license&activation_id=' + encodeURIComponent(activationId)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        confirmBtn.classList.remove('orangeBtn');
                        confirmBtn.classList.remove('warningBtn');
                        confirmBtn.classList.add('drkBtn');
                        confirmBtn.classList.add('deactivated');
                        confirmBtn.textContent = 'Deactivated!';
                        confirmBtn.disabled = true;
                        confirmBtn.setAttribute('tabindex', '-1');
                        confirmBtn.style.cursor = 'not-allowed';
                        confirmBtn.style.opacity = '0.7';
                    } else {
                        confirmBtn.textContent = 'Error! Try Again';
                        confirmBtn.classList.remove('drkBtn');
                        confirmBtn.classList.remove('orangeBtn');
                        confirmBtn.classList.add('warningBtn');
                        setTimeout(function() {
                            confirmBtn.classList.remove('warningBtn');
                            confirmBtn.classList.remove('drkBtn');
                            confirmBtn.classList.add('orangeBtn');
                            confirmBtn.textContent = 'Confirm Deactivation';
                            confirmBtn.disabled = false;
                            confirmBtn.removeAttribute('inert');
                            confirmBtn.removeAttribute('tabindex');
                            confirmBtn.style.pointerEvents = '';
                            confirmed = false;
                        }, 4000);
                    }
                });
            });
        });
    });
    </script>
    
<?php }