<?php
/**
 * Plugin Name: Luna - Auto Update Product HTML
 * Description: Automatically updates old product listings with dynamic HTML content based on product title.
 * Version: 1.0
 * Author: Luna
 */

function read_csv($file_path) {
    $data = [];
    if (($handle = fopen($file_path, "r")) !== FALSE) {
        $header = fgetcsv($handle); 
        while (($row = fgetcsv($handle)) !== FALSE) {
            $data[] = array_combine($header, $row); 
        }
        fclose($handle);
    }
    return $data;
}

function get_club_data_from_csv($title) {
    $file_path = plugin_dir_path(__FILE__) . 'about_club.csv';
    $club_data = read_csv($file_path);
    
    foreach ($club_data as $row) {
        if (stripos($title, $row['club_name']) !== false) {
            return [
                'club_name' => $row['club_name'],
                'about_club' => $row['about_club'],
                'related_product' => $row['related_product']
            ];
        }
    }
    return null;
}

function get_player_data_from_csv($title) {
    $file_path = plugin_dir_path(__FILE__) . 'players.csv';
    $player_data = read_csv($file_path);
    
    foreach ($player_data as $row) {
        if (stripos($title, $row['player_name']) !== false) {
            return $row['player_name'];
        }
    }
    return null;
}

function format_product_title($title) {
    $title = preg_replace_callback('/(\d{4})\/(\d{2})/', function($matches) {
        $year1 = substr($matches[1], -2);
        $year2 = $matches[2]; 
        return $year1 . '/' . $year2;
    }, $title);

    $title = preg_replace('/(.*?)(\d{2}\/\d{2})(.*)/', '$1 $2$3', $title);

    return $title;
}

function update_product_html($product_id, $title) {
    $formatted_title = format_product_title($title);
    $club_data = get_club_data_from_csv($title);
    $player_name = get_player_data_from_csv($title);

    if ($club_data) {
        $about_club = $club_data['about_club'];
        $related_product = $club_data['related_product'];

        $html_content_about_club = "
            <h2>About {$club_data['club_name']}</h2>
            <p>{$about_club}</p>
        ";
        
        $html_content_related_product = "
            <h2>Check out other {$club_data['club_name']} football shirts and kits</h2>
            {$related_product}
        ";

        $full_html = "
            <a href='https://kidsfootballkit.co.uk/wp-content/uploads/2025/04/KFK-information.png'>
                <img class='aligncenter wp-image-109781' src='https://kidsfootballkit.co.uk/wp-content/uploads/2025/04/KFK-information.png' alt='KFK - information' width='732' height='549'/>
            </a>
            <p class='p1' style='text-align: center;'><span style='color: #999999;'><em>-(Please scroll up for more details)--</em></span></p>
            <div data-page-id='VjctdqtAsoIxXRxdpWku8mFDs6X' data-docx-has-block-data='false'>
                <h2 class='heading-2'>{$formatted_title} details</h2>
                <div data-lark-html-role='root'>
                    Our <strong>{$formatted_title}</strong> includes the items shown in the photo at the time of your order.
                    We’re proud to offer high-quality replicas with a <strong>98%</strong> resemblance to the originals – carefully crafted to mirror the real shirts and kits.
                    <strong>Delivery usually takes 7–12 working days</strong>, though occasional delays may occur due to unforeseen circumstances.
                    Designed with a standard fit, the kit offers a relaxed, comfortable feel that lets kids move freely while looking great.
                </div>    
                <br>
                <h2 data-start='245' data-end='274'>Shipping Information</h2>
                <p class='' data-start='275' data-end='611'>We currently offer shipping to <strong>the UK, France, Germany, Ireland, Spain and Netherland</strong></p>
                <p class='' data-start='275' data-end='611'>Please note that <strong data-start='369' data-end='420'>shipping fees vary </strong>depending on the destination.</p>
                <p class='' data-start='275' data-end='611'>Before finalising your order, we kindly suggest <strong>reviewing the delivery time and applicable shipping fee</strong> at checkout to avoid any unexpected costs.</p>
                
                <h2 data-start='618' data-end='642'>Personalisation</h2>
                <p class='' data-start='643' data-end='990'>If you’d like to personalise your kit, simply select your size and enter your <strong data-start='721' data-end='758'>preferred name (up to 13 letters)</strong> and <strong data-start='763' data-end='790'>number (up to 2 digits)</strong> in the personalisation box.</p>
                <p data-start='643' data-end='990'>Please make sure the spelling and number are correct before completing your purchase, as <strong data-start='910' data-end='989'>we’re unable to make changes or offer refunds once the item is personalised</strong>.</p>

                <h2 data-start='1508' data-end='1532'>Payment Options</h2>
                <p class='' data-start='1536' data-end='1625'>We provide secure and convenient payment methods to make your shopping experience smooth:</p>

                <ol data-start='1627' data-end='1868'>
                    <li class='' data-start='1627' data-end='1710'>
                        <p class='' data-start='1630' data-end='1710'><strong data-start='1630' data-end='1640'>PayPal</strong> – Select PayPal at checkout and complete your transaction securely.</p>
                    </li>
                    <li class='' data-start='1711' data-end='1868'>
                        <p class='' data-start='1714' data-end='1868'><strong data-start='1714' data-end='1729'>Credit Card</strong> – Choose the credit card option and enter your card number, expiry date, and CVV code. Your information is encrypted and handled safely.</p>
                    </li>
                </ol>
                <p class='' data-start='1870' data-end='2033'>👉 If you're unsure how to pay by card, please check out our <a href='https://kidsfootballkit.co.uk/a-step-by-step-guide-to-making-credit-card-payments/'><strong data-start='1931' data-end='1960'>Card Payment Instructions</strong></a> for a clear, step-by-step guide.</p>
                
                <h2 data-start='1272' data-end='1291'>Size Chart</h2>
                <p class='' data-start='1292' data-end='1501'>To ensure the perfect fit, please review our Size Chart carefully before placing your order.</p>
                <p class='' data-start='1292' data-end='1501'>You can find sizing information in the <strong>product gallery</strong> or on our dedicated <strong><a href='https://kidsfootballkit.co.uk/size-chart/'>Size Guide page</a></strong></p>
                
                {$html_content_about_club} <!-- Insert About Club section -->
                
                <h2>Washing Instruction</h2>
                <h2><strong><img class='aligncenter wp-image-32177' src='https://kidsfootballkit.co.uk/wp-content/uploads/2023/09/KFK-washing-instruction.png' alt='Portugal World Cup Away Kids Kit Ronaldo 7' width='574' height='459' /></strong></h2>
                <h2 data-start='2060' data-end='2211'>📧 How to contact us?</h2>
                <p data-start='2060' data-end='2211'>For any questions about your order or delivery (e.g. the <strong data-start='2117' data-end='2152'>{$formatted_title}), feel free to <span style='text-decoration: underline;'><strong><a href='https://kidsfootballkit.co.uk/contact/'>contact us here</a></strong></span></p>
                <p class='' data-start='2213' data-end='2437'>If you haven’t received your confirmation email, please check your <strong data-start='2280' data-end='2303'>spam or junk folder</strong>, as sometimes emails can be filtered there.</p>
                <p class='' data-start='2213' data-end='2437'>We’ll also send updates via email, so kindly keep an eye on your inbox and spam folder.</p>
                
                {$html_content_related_product} <!-- Insert Related Product section -->
            </div>
        ";

        if ($player_name) {
            $full_html = preg_replace(
                '/<h2 data-start=\'618\' data-end=\'642\'>Personalisation<\/h2>\s*<p class=\'\' data-start=\'643\' data-end=\'990\'>.*?<\/p>\s*<p data-start=\'643\' data-end=\'990\'>.*?<\/p>/is',
                '',
                $full_html
            );
        }

        wp_update_post([
            'ID' => $product_id,
            'post_content' => $full_html,
        ]);
    }
}


add_action('admin_post_update_product_html', 'update_all_products');

add_action('admin_menu', function () {
    add_menu_page(
        'Luna - Auto Update Product HTML',
        'Luna - Auto Update Product HTML',
        'manage_options',
        'auto-update-product-html',
        'auto_update_product_html_page',
        'dashicons-edit',
        30
    );
});

function auto_update_product_html_page() {
    $message = '';

    if (isset($_POST['run_once']) && check_admin_referer('run_action_nonce')) {
        $settings = get_form_settings();
        update_option('last_settings', $settings);
        $message = process_batch($settings);
    }

    if (isset($_POST['run_auto']) && check_admin_referer('run_action_nonce')) {
        $settings = get_form_settings();
        update_option('last_settings', $settings);
        update_option('auto_run_active', true);
        update_option('auto_run_started_at', time());
        update_option('auto_settings', $settings);
    }

    if (isset($_POST['stop_action']) && check_admin_referer('stop_action_nonce')) {
        update_option('auto_run_active', false);
    }

    ?>
    <style>
    .auto-update-container {
        max-width: 800px;
        margin: 30px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    </style>

    <div class="wrap auto-update-container">
        <h1>Luna - Auto Update Product HTML</h1>
        
        <h2>Batch Update Settings</h2>
        <form method="post" id="form">
            <?php wp_nonce_field('run_action_nonce'); ?>
            <table class="form-table">
                <tr><th>Batch Size</th><td><input type="number" name="batch_size" value="1"></td></tr>
                <tr><th>Mode</th>
                    <td>
                        <label><input type="radio" name="mode" value="add" checked> Add</label>
                        <label><input type="radio" name="mode" value="remove"> Remove</label>
                    </td>
                </tr>
            </table>
            <p>
                <input type="submit" name="run_once" class="button button-primary" value="Run Once">
                <input type="submit" name="run_auto" class="button button-secondary" value="Start Auto Run Every 5s">
            </p>
        </form>

        <form method="post" style="display:inline-block;">
            <?php wp_nonce_field('stop_action_nonce'); ?>
            <input type="submit" name="stop_action" class="button" value="Stop Auto Run">
        </form>

        <?php if ($message): ?>
            <div class="notice notice-success"><p><?= esc_html($message) ?></p></div>
        <?php endif; ?>
    </div>
    <?php
}

function get_form_settings() {
    return [
        'batch_size' => isset($_POST['batch_size']) ? max(1, intval($_POST['batch_size'])) : 100,
        'mode' => $_POST['mode'] ?? 'add',
    ];
}

function process_batch($settings) {
    $batch_size = $settings['batch_size'];
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $batch_size,
        'post_status' => 'publish',
    ];
    $products = get_posts($args);

    foreach ($products as $product) {
        $title = $product->post_title;
        update_product_html($product->ID, $title);
    }

    return "Batch processed successfully!";
}
?>
